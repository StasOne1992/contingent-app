<?php

namespace App\mod_education\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\MainApp\Entity\college;
use App\MainApp\Entity\Staff;
use App\mod_education\Repository\StudentGroupsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'student_group:item']),
        new GetCollection(normalizationContext: ['groups' => 'student_group:list'])
    ]
)]
#[ORM\Entity(repositoryClass: StudentGroupsRepository::class)]
class StudentGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups(
        [
            'student_group:list',
            'student_group:item',
            'contingent_document:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 12)]
    #[Groups(
        [
            'student_group:list',
            'student_group:item',
            'contingent_document:item',
        ]
    )]
    private ?string $Name = " ";

    #[ORM\ManyToOne(inversedBy: 'studentGroup')]
    #[Groups(
        [
            'student_group:list',
            'student_group:item',
        ]
    )]
    private ?Faculty $Faculty = null;
    #[ORM\ManyToOne(inversedBy: 'studentGroup')]
    #[Groups(
        [
            'student_group:list',
            'student_group:item',
        ]
    )]
    private College|null $college = null;

    #[ORM\ManyToOne(inversedBy: 'studentGroup')]
    #[Groups(
        [
            'student_group:list',
            'student_group:item',
        ]
    )]
    private ?Staff $GroupLeader = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(
        [
            'student_group:list',
            'student_group:item',
            'contingent_document:item',
        ]
    )]
    private ?string $Code = " ";

    #[ORM\OneToMany(mappedBy: 'studentGroup', targetEntity: Student::class)]
    private Collection $students;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DataEnd = null;

    #[ORM\Column(nullable: true)]
    private ?int $CourseNumber = 1;

    #[ORM\ManyToOne(inversedBy: 'studentGroup')]
    private ?EducationPlan $EducationPlan = null;

    #[ORM\Column(nullable: true)]
    private ?int $ParallelNumber = 1;
    #[ORM\OneToMany(mappedBy: 'StudentGroup', targetEntity: GroupMembership::class)]
    private Collection $groupMemberships;
    private ?array $socialPassport = array();

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFaculty(): ?Faculty
    {
        return $this->Faculty;
    }

    public function setFaculty(?Faculty $Faculty): self
    {
        $this->Faculty = $Faculty;

        return $this;
    }

    public function getGroupLeader(): ?Staff
    {
        return $this->GroupLeader;
    }

    public function setGroupLeader(?Staff $GroupLeader): self
    {
        $this->GroupLeader = $GroupLeader;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): self
    {
        $this->Code = $Code;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getActiveStudents(): Collection
    {
        return $this->getStudents()->filter(
            function ($item) {
                if ($item->isIsActive()) {
                    return $item;
                }
                return null;
            }
        );
    }


    /**
     * @return Collection<int, Student>
     */
    public function getPunishmentsStudents(): Collection
    {
        return $this->getStudents()->filter(
        /***
         * @var Student $item
         */
            function ($item) {
                if ($item->getPunishmentStatus()) {
                    return $item;
                }
                return null;
            }
        );
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setStudentGroup($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getStudentGroup() === $this) {
                $student->setStudentGroup(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() . ' (' . $this->getCode() . ')';
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->DateStart;
    }

    public function setDateStart(?\DateTimeInterface $DateStart): self
    {
        $this->DateStart = $DateStart;

        return $this;
    }

    public function getDataEnd(): ?\DateTimeInterface
    {
        return $this->DataEnd;
    }

    public function setDataEnd(?\DateTimeInterface $DataEnd): self
    {
        $this->DataEnd = $DataEnd;

        return $this;
    }

    public function getCourseNumber(): ?int
    {
        return $this->CourseNumber;
    }

    public function setCourseNumber(int $CourseNumber): self
    {
        $this->CourseNumber = $CourseNumber;

        return $this;
    }

    public function getEducationPlan(): ?EducationPlan
    {
        return $this->EducationPlan;
    }

    public function setEducationPlan(?EducationPlan $EducationPlan): static
    {
        $this->EducationPlan = $EducationPlan;

        return $this;
    }

    public function getParallelNumber(): ?int
    {
        return $this->ParallelNumber;
    }

    public function setParallelNumber(?int $ParallelNumber): static
    {
        $this->ParallelNumber = $ParallelNumber;

        return $this;
    }

    public function getAsJson(): array
    {
        return get_object_vars($this);
    }

    public function getSocialPassport(): array
    {

        /**
         * coutnStudents - всего
         * countWoman - женщины
         * countMan - мужчины
         *  countUnderage - не совершеннолетние
         *  countAdult - совершеннолетние
         * countOrphan - сироты
         * countInvalid - инвалиды и ОВЗ
         * countIsPoor - малоимущие
         * countWithoutParents - дети, оставшиеся без попечения родителей*/
        $this->socialPassport['countStudents'] = $this->count();
        $this->socialPassport['countWoman'] = $this->countFemale();
        $this->socialPassport['countMan'] = $this->countMale();
        $this->socialPassport['countNotAdult'] = $this->countNotAdult();
        $this->socialPassport['countAdult'] = $this->countAdult();
        $this->socialPassport['countOrphan'] = $this->countIsOrphan();
        $this->socialPassport['countInvalid'] = $this->countIsInvalid();
        $this->socialPassport['countWithoutParents'] = $this->countIsWithoutParents();
        $this->socialPassport['countIsPoor'] = $this->countIsPoor();
        $this->socialPassport['countLiveStudentAccommodation'] = $this->countLiveStudentAccommodation();
        $this->socialPassport['countStudentsHavePunishment'] = count($this->getPunishmentsStudents());
        return $this->socialPassport;
    }

    /***
     * Функция возвращает количество студентов в группе
     * @return int
     */
    public function count(): int
    {
        return count($this->getStudents()->getValues());
    }

    /***
     * Функция возвращает количество студентов мужского пола
     * @return int
     */
    public function countMale(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if ($student->isMale()) $result += 1;
        }
        return $result;
    }

    /***
     * Функция возвращает количество студентов женского пола
     * @return int
     */
    public function countFemale(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if (!$student->isMale()) $result += 1;
        }
        return $result;
    }

    /***
     * Функция возвращает количество совершеннолетних студентов
     * @return int
     */
    public function countAdult(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if ($student->isAdult()) $result += 1;
        }
        return $result;
    }

    /***
     * Функция возвращает количество несовершеннолетних студентов
     * @return int
     */
    public function countNotAdult(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if (!$student->isAdult()) $result += 1;

        }
        return $result;
    }

    public function countIsOrphan(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if ($student->isIsOrphan()) $result += 1;
        }
        return $result;
    }

    public function countIsInvalid(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if ($student->isIsInvalid()) $result += 1;
        }
        return $result;
    }

    public function countIsPoor(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if ($student->isIsPoor()) $result += 1;
        }
        return $result;
    }

    public function countIsWithoutParents(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if ($student->isIsWithoutParents()) $result += 1;
        }
        return $result;
    }

    public function countLiveStudentAccommodation(): int
    {
        $result = 0;
        foreach ($this->getStudents() as $student) {
            if (!$student->isIsLiveStudentAccommondation()) $result += 1;
        }
        return $result;
    }

    public function getGroupMemberships(): Collection
    {
        return $this->groupMemberships;
    }

    public function getGroupMembershipsStudents(): Collection
    {
        $students = new ArrayCollection();
        foreach ($this->groupMemberships as $groupMembership) {
            $students->add($groupMembership->getStudent());
        }
        return $students;
    }
    public function setGroupMemberships(Collection $groupMemberships): void
    {
        $this->groupMemberships = $groupMemberships;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): void
    {
        $this->college = $college;
    }


}

