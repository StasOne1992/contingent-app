<?php

namespace App\MainApp\Service;

use App\MainApp\Entity\AccessSystemControl;
use App\MainApp\Entity\AdmissionPlan;
use App\MainApp\Entity\Student;
use App\MainApp\Entity\StudentGroups;
use App\MainApp\Repository\AbiturientPetitionRepository;
use App\MainApp\Repository\CollegeRepository;
use App\MainApp\Repository\StudentGroupsRepository;


class TypicalDocuments
{
    private $college;
    private $collegeRepo;

    public function __construct(
        public CollegeRepository                    $collegeRepository,
        public StudentGroupsRepository              $StudentGroupRepo,
        private AbiturientPetitionRepository $abiturientPetitionRepository,
        private RFIDService                  $RFIDService,
    )
    {
        $this->collegeRepo = $collegeRepository;
        $this->StudentGroupRepo = $StudentGroupRepo;

    }

    /**
     * @param bool $logo Включить ли логотип
     * @return string
     */
    public function getHeader($logo = true,$contacts=true)
    {
        $collegeName = str_replace("\r\n", '<br>', $this->college->getFullName());
        $collegeAddress = '<p style="text-align: center;font-size: small">' . $this->college->getPostalAddress() . '</p>';

        if ($contacts) {
            $collegeContacts = '<p style="text-align: center;font-size: small">' . 'Телефон:' . $this->college->getPhone() . ' Факс:' . $this->college->getFax() . '<br>' . ' e-mail:' . $this->college->getEmail() . ' ' . $this->college->getWebSite() . '</p>';
        }
        else
        {
            $collegeContacts='';
        }
        if ($logo) {

            $image = $this->college->getLogo();
            /*$type = pathinfo($image, PATHINFO_EXTENSION);
            $data = file_get_contents($image);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);*/
            $logo = ' <img src="data:image/png;base64,' . base64_encode(file_get_contents('https://' . $_SERVER['HTTP_HOST'] . $image)) . '">';
            #$logo = '<img style="display: block; height:2cm; margin: 0 auto;" src="' . base64_encode($image). '">';

        } else {
            $logo = '';
        }
        $header = $logo . '<p style="text-align: center"><b>' . $collegeName . '</b></p>' . $collegeAddress . $collegeContacts;
        return $header;
    }

    public function newpage($content)
    {
        return '<div class="main-page"><div class="sub-page">' . $content . '</div></div>';
    }

    private function setCollege($collegeId): void
    {
        $this->college = $this->collegeRepo->findBy(['id' => $collegeId])[0];
    }

    public function generateOrder($content): ?string
    {
        $this->setCollege(1);
        $header = $this->getHeader(false);
        $subheader = '<h3 style="text-align: center;text-transform: uppercase">Приказ</h3>';
        $createDate = $content->getCreateDate();
        $createDate = $createDate->format('d.m.Y');
        $documentNumber = $content->getNumber();
        $subheader = $subheader . '<p style="text-align-last: justify">от' . $createDate . ' ' . $documentNumber . '</p>';
        $subheader = $subheader . '<p style="text-align: center">г. Волоколамск</p>';
        $subheader = $subheader . '<p style="font-weight: bold;font-style: italic">"' . $content->getName() . '"</p><br>';
        $documentPreambula = '<span style="text-align: justify;text-align-last: left;">На основании ' . $content->getReason() . ', в соответствии с правилами приёма в ГБПОУ МО "ВАТ "Холмогорка" в 2022 году, в соответствии с контрольными цифрами приёма, </span>';
        $documentBody = '<p style="text-align: justify; text-align-last: left;">1. Зачислить с 01.09.2022 г. в число студентов ГБПОУ МО "ВАТ "Холмогорка" на 1 курс по очной форме обучения за счёт бюджетных ассигнований бюджета Московской области лиц, рекомендованных Приемной комиссией к зачислению и представивших оригиналы соответствующих документов согласно приложению 1 к Приказу.</p>';

        $documentBody = $documentBody . "<br><br> <span style='font-weight: bold;font-style: italic'>Основание:</span> " . $content->getReason();
        $documentBody = $documentBody . '<br><br>';

        $pages[] = $this->newpage($header . '<hr style="margin: 0;padding: 0;height: 8px;border: none;border-top: 4px solid #333; border-bottom: 2px solid #333;">' . $subheader . '' . $documentPreambula . '<span style="text-transform:lowercase;font-weight: bold;letter-spacing: 3px">Приказываю:</span><br><br>' . $documentBody);
        $header = '<div style="margin-left:12cm;text-align: justify"><span >Приложение 1 к приказу <br> от ' . $createDate . ' г. № ' . $content->getNumber() . '</span></div><br>';
        $rc = array();

        foreach ((array)$content->getStudent()->getValues() as $data) {
            /**
             * @var Student $data
             */

            $rc[$data->getStudentGroup()->getId()][] = $data;
        }
        $itter = 0;
        foreach ($rc as $group) {
            $currgroup = $this->StudentGroupRepo->findOneBy(['id' => key($rc)]);
            $itter = 1 + $itter;
            $groupHeader = '<p style="font-weight: bold">' . $itter . '. Специальность ' . $currgroup->getFaculty()->getSpecialization()->getCode()
                . ' ' . $currgroup->getFaculty()->getName() . ' <span style="text-transform: lowercase"> ' . $currgroup->getFaculty()->getEducationForm()->getTitle() . ' форма обучения</span> '
                . ' <span style=""> (' . $currgroup->getFaculty()->getEducationType()->getTitle() . ')</span> '
                . '</p>';
            $groupList = '';
            $inGroupItter = 0;
            foreach ($group as $student) {
                $inGroupItter = $inGroupItter + 1;
                $groupList = $groupList . '<p style="line-height:8px">' . $inGroupItter . '. ' . $student->getLastName() . ' ' . $student->getFirstName() . ' ' . $student->getMiddleName() . '</p>';
            }
            $addPage = $groupHeader . '<br>' . $groupList;

        }
        $pages[] = $this->newpage($header . $addPage);
        $result = implode('<div class="page_break"></div>', $pages);

        return $result;
    }


    /***
     * @param $admissionPlanPosition AdmissionPlan
     * @return void
     */
    public function generateAdmissionExaminationResultReport($admissionPlanPosition)
    {
        $pages = array();
        $this->setCollege(1);
        $header = $this->getHeader(false);

        $subheader = '<h2 style="text-align: center;text-transform: uppercase; margin: 0px">Протокол</h2><h3 style="margin: 0px;text-align: center;line-height: 1"">вступительного испытания</h3><br>';
        $createDate = date('d.m.Y');
        $documentNumber = 1;
        $subheader = $subheader .
            '<table  style="width: 100%;margin-bottom: 20px">
            <tr>
                <td style=" border: 0px; "> от ' . $createDate . '</td>
                <td style=" border: 0px; "> </td>
                <td style=" border: 0px; "> № ' . $documentNumber . '</td>
            </tr>
            </table>
            ';
        $admissionPlanPosition->getFaculty();
        $subheader = $subheader . '<h4 style="text-align: center;">Вступительные испытания по специальности ' . $admissionPlanPosition->getFaculty()->getSpecialization()->getCode() . ' ' . $admissionPlanPosition->getFaculty() . '<hr><span style="font-size: 10px">(наименование вступительного испытания)</span> </h4>';
        $body = '
            <table border="1" style="width: 100%;margin-bottom: 20px;margin-top: 30px;font-size: 12px; padding-bottom: 20px;">

            <tr>
            <th style="width: 5%">№ п/п</th>
            <th style="width: 30%">ФИО поступающего</th>';
        $examination = array();
        foreach ($admissionPlanPosition->getAdmissionExaminations() as $admissionExamination) {
            $examination[] = $admissionExamination;
            $body = $body . '<th style="width: 20%">Результат вступительного испытания <br>' . $admissionExamination->getExaminationSubject() . ', балл</th>';
        }
        $body = $body . '<th style="width: 25%">Подписи председателя и членов экзаменационной комиссии</th>
            </tr>

            ';
        $itter = 1;
        $countPass = 0;
        $countNotPass = 0;
        $countIsRemoved = 0;
        $abiturientPetition = $this->abiturientPetitionRepository->findBy(['AdmissionPlanPosition' => $admissionPlanPosition]);
        foreach ($abiturientPetition as $petition) {
            $currentcountNotPass = 0;
            $currentcountPass = 0;
            $body = $body . '<tr><td  style="width: 5%">' . $itter . '</td>';
            $body = $body . '<td align="left" style="width: 30%">' . $petition->getLastName() . ' ' . $petition->getFirstName() . ' ' . $petition->getMiddleName() . '</td>';
            foreach ($examination as $examinationitem) {
                foreach ($petition->getResult()->getValues() as $ExaminationResult) {
                    if ($examinationitem == $ExaminationResult->getAdmissionExamination()) {
                        $body = $body . '<td  align="center" style="width: 20%">';
                        if ($ExaminationResult->getMark() != 0) {
                            $body = $body . $ExaminationResult->getMark();
                            $currentcountPass = $currentcountPass + 1;
                        } elseif ($ExaminationResult->getMark() < $ExaminationResult->getAdmissionExamination()->getPassScore() and $ExaminationResult->getMark() != 0) {
                            $body = $body . 'не зачтено';
                            $currentcountPass = $currentcountPass + 1;
                        } else {
                            $body = $body . 'неявка';
                            $currentcountNotPass = $currentcountNotPass + 1;
                        }

                        $body = $body . '</td>';
                    }
                }
            }
            $body = $body . '<td style="width: 25%"> </td></tr>';
            $itter = $itter + 1;
            if ($currentcountPass >= 1) {
                $countPass = $countPass + 1;
            }
            if ($currentcountNotPass >= 1) {
                $countNotPass = $countNotPass + 1;
            }
        }

        $body = $body . '</tbody></table>';
        $body = $body . '<p>Число поступающих, явившихся на вступительное испытание: ' . $countPass . ' </p>';
        $body = $body . '<p>Число поступающих, неявившихся на вступительное испытание: ' . $countNotPass . '</p>';
        $body = $body . '<p>Число поступающих, удаленных с места проведения вступительного испытания: ' . $countIsRemoved . '</p>';
        $body = $body . '<br>';

        $body = $body . '<table class="no-border" style="width: 100%;border: 0px">
        <tr>
            <td class=no-border" style="width:60 %" colspan="3">Председатель экзаменационной комиссии:</td>
        </tr>
        <tr>
            <td style="width:60 % ;height: 40px; border-bottom: 1px solid black;text-align: center">Малахова Любовь Ивановна</td>
            <td style="width:10 %"></td>
            <td style="width:30 %; border-bottom: 1px solid black; "> </td>
        </tr>
            <tr>
                <td style="width:50 %"><p style="font-size: 8px;text-align: center">(фамилия, имя, отчество председателя экзаменационной комиссии)</p></td>
                <td  style="width:60px"> </td>
                <td  style="width:30 % "><p align="center" style="font-size: 8px;text-align: center">(подпись)</p></td>
            </tr>
             <tr>
            <td class=no-border" style="width:60 %" colspan="3">Члены экзаменационной комиссии:</td>
        </tr>';

        $comission[] = 'Гришина Ольга Валерьевна';
        $comission[] = 'Макарова Лариса Юрьевна';
        foreach ($comission as $item) {
            $body = $body . '<tr>
            <td style="width:60 % ;height: 30px; border-bottom: 1px solid black;text-align: center">' . $item . '</td>
            <td style="width:10 %"></td>
            <td style="width:30 % ; border-bottom: 1px solid black;"> </td>
        </tr>
       
                <tr>
            <td style="width:50 %"><p style="font-size: 8px;text-align: center">(фамилия, имя, отчество члена экзаменационной комиссии)</p></td>
            <td  style="width:40px"> </td>
            <td  style="width:30 % "><p align="center" style="font-size: 8px;text-align: center">(подпись)</p></td>
        </tr>';
        }


        $body = $body . '</table>';


        $pages[] = $header . $subheader . $body;
        $bodysummary = '';
        $footer = '';

        return implode('', $pages);;

    }


    /**
     * @param StudentGroups $content
     * @return void
     */
    public function generateSKUDRulesAccept($content)
    {
        $this->setCollege(1);
        $page = $this->getHeader(false,false) .
            '<hr style="margin: 0;padding: 0;height: 3px;border: none;border-top: 4px solid #333; border-bottom: 2px solid #333;">' .
            '
        <h3 align="center"><b>
        <span style="text-transform: uppercase">Лист ознакомления студентов</span>
        </h3>
        <p align="center"><i>с Положением об организации пропускного режима в ГБПОУ МО «Волоколамский аграрный техникум «Холмогорка» с использованием автоматизированной системы контроля и управления доступом (СКУД) (локальный акт № 186), инструкцией по использованию системы контроля доступа) (локальный акт № 184) утвержденных приказом директора ГБПОУ МО «ВАТ Холмогорка» 
от 10 января 2019 года № 1/1</i></p>
<p style="margin-top: 0.5cm" align="center">Группа <b>' . $content . '</b></p>        
        ';
        /**
         * @var StudentGroups $content
         */
        $studentslist = $content->getStudents()->toArray();
        $itter = 0;
        foreach ($studentslist as $student) {
            $itter = $itter + 1;
            $data[$itter]['UUID'] = $student->getUUID();
            $data[$itter]['LastName'] = $student->getLastName();
            $data[$itter]['FirstName'] = $student->getFirstName();
            $data[$itter]['MiddleName'] = $student->getMiddleName();
            $data[$itter]['Position'] = 'Студент';
            $data[$itter]['Group'] = $content->getCode();
            $data[$itter]['DateInPoo'] = $content->getDateStart()->format('d.m.Y');;
            /**
             * @var AccessSystemControl $card
             */
            foreach ($student->getAccessSystemControls() as $card) {
                $convert = $this->RFIDService->convert('hid', str_pad($card->getAccessCardSeries(), 3, '0', STR_PAD_LEFT) . ',' . str_pad($card->getAccesCardNumber(), 6, '0', STR_PAD_LEFT));
                $data[$itter]['CardID'] = str_pad($card->getAccessCardSeries(), 3, '0', STR_PAD_LEFT) . '/' . str_pad($card->getAccesCardNumber(), 5, '0', STR_PAD_LEFT); //$convert['id'];
            }
            $data[$itter]['AccessRules'] = 'калитка_учебный_корпус';
        };

        //        $item['UUID'] = 'Таб. №';
        //        $item['LastName'] = 'Фамилия';
        //        $item['FirstName'] = 'Имя';
        //        $item['MiddleName'] = 'Отчество';
        //        $item['Position'] = 'Должность';
        //        $item['Group'] = 'Подразделение';
        //        $item['DateInPoo'] = 'Дата начала действия';
        //        $item['CardID'] = 'Карта - ID';
        //        $item['AccessRules'] = 'Схема доступа';

        $table = '<table style="width: 100%;">
            <thead>
            <tr>
            <th style="width: 1.2cm ;border: 1px solid ;">№ п/п</th>
            <th style=";border: 1px solid ;">Таб. №</th>
            <th style=";border: 1px solid ;">Студент</th>
            <th style=";border: 1px solid ;">ИД карты</th>
            <th style=";border: 1px solid ;">Дата выдачи</th>
            <th  style=";border: 1px solid ;">Подпись</th>
</tr>
            </thead>
            ';
        $itter=1;
        foreach ($data as $item) {
            $table= $table.'<tr>' .
            '<td style="text-align: center ;border: 1px solid ;">'.$itter.'</td>' .
                '<td style="text-align: center;border: 1px solid ;">'.$item['UUID'] .'</td>' .
                '<td style="text-align: left;border: 1px solid ;">'. $item['LastName'] .' '. $item['FirstName'] .' '.  $item['MiddleName'] .'</td>' .
                '<td style="text-align: left;border: 1px solid ;">'. $item['CardID'] .'</td>' .
                '<td style="text-align: center;border: 1px solid ;">'.'01.09.2023' .'</td>' .
                '<td style="text-align: center;border: 1px solid ;"></td>' .
            '</tr>';
            $itter++;
        };


        return $this->newpage($page.$table);

    }

    public function generateSKUDissue($content)
    {
        $this->setCollege(1);
        $page = $this->getHeader(false,false) .
            '<hr style="margin: 0;padding: 0;height: 3px;border: none;border-top: 4px solid #333; border-bottom: 2px solid #333;">' .
            '
        <h3 align="center"><b>
        <span style="text-transform: uppercase">Ведомость<br> учёта выдачи электронных пропусков</span>
        </h3>
<p style="margin-top: 0.5cm" align="center">Группа <b>' . $content . '</b></p>        
        ';
        /**
         * @var StudentGroups $content
         */
        $studentslist = $content->getStudents()->toArray();
        $itter = 0;
        foreach ($studentslist as $student) {
            $itter = $itter + 1;
            $data[$itter]['UUID'] = $student->getUUID();
            $data[$itter]['LastName'] = $student->getLastName();
            $data[$itter]['FirstName'] = $student->getFirstName();
            $data[$itter]['MiddleName'] = $student->getMiddleName();
            $data[$itter]['Position'] = 'Студент';
            $data[$itter]['Group'] = $content->getCode();
            $data[$itter]['DateInPoo'] = $content->getDateStart()->format('d.m.Y');;
            /**
             * @var AccessSystemControl $card
             */
            foreach ($student->getAccessSystemControls() as $card) {
                $convert = $this->RFIDService->convert('hid', str_pad($card->getAccessCardSeries(), 3, '0', STR_PAD_LEFT) . ',' . str_pad($card->getAccesCardNumber(), 6, '0', STR_PAD_LEFT));
                $data[$itter]['CardID'] = str_pad($card->getAccessCardSeries(), 3, '0', STR_PAD_LEFT) . '/' . str_pad($card->getAccesCardNumber(), 5, '0', STR_PAD_LEFT); //$convert['id'];
            }
            $data[$itter]['AccessRules'] = 'калитка_учебный_корпус';
        };

        //        $item['UUID'] = 'Таб. №';
        //        $item['LastName'] = 'Фамилия';
        //        $item['FirstName'] = 'Имя';
        //        $item['MiddleName'] = 'Отчество';
        //        $item['Position'] = 'Должность';
        //        $item['Group'] = 'Подразделение';
        //        $item['DateInPoo'] = 'Дата начала действия';
        //        $item['CardID'] = 'Карта - ID';
        //        $item['AccessRules'] = 'Схема доступа';

        $table = '<table style="width: 100%;">
            <thead>
            <tr>
            <th style="width: 1.2cm ;border: 1px solid ;">№ п/п</th>
            <th style=";border: 1px solid ;">Таб. №</th>
            <th style=";border: 1px solid ;">Студент</th>
            <th style=";border: 1px solid ;">ИД карты</th>
            <th style=";border: 1px solid ;">Дата выдачи</th>
            <th  style=";border: 1px solid ;">Подпись</th>
</tr>
            </thead>
            ';
        $itter=1;
        foreach ($data as $item) {
            $table= $table.'<tr>' .
                '<td style="text-align: center ;border: 1px solid ;">'.$itter.'</td>' .
                '<td style="text-align: center;border: 1px solid ;">'.$item['UUID'] .'</td>' .
                '<td style="text-align: left;border: 1px solid ;">'. $item['LastName'] .' '. $item['FirstName'] .' '.  $item['MiddleName'] .'</td>' .
                '<td style="text-align: center;border: 1px solid ;">'. $item['CardID'] .'</td>' .
                '<td style="text-align: center;border: 1px solid ;">'.'01.09.2023' .'</td>' .
                '<td style="text-align: center;border: 1px solid ;"></td>' .
                '</tr>';
            $itter++;
        };


        return $this->newpage($page.$table);

    }
}