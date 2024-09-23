<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\CharacteristicRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharacteristicRepository::class)]
class Characteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'characteristics')]
    private ?Student $Student = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $CreateData = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Content = null;

    #[ORM\Column(nullable: true)]
    private ?array $answers = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setStudent(?Student $Student): self
    {
        $this->Student = $Student;

        return $this;
    }

    public function getCreateData(): ?\DateTimeInterface
    {
        return $this->CreateData;
    }

    public function setCreateData(\DateTimeInterface $CreateData): self
    {
        $this->CreateData = $CreateData;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function daysCountString($ndata):string
    {

        if( $ndata == '1'){
            return $ndata." день";
        } elseif( str_ends_with($ndata, -1) == '2'){
            return $ndata." дня";
        } elseif(  str_ends_with($ndata, -1) == '3'){
            return $ndata." дня";
        } elseif(  str_ends_with($ndata, -1) == '4'){
            return $ndata." дня";
        } else {
            return $ndata." дней";
        }
    }


    public function checkValidation(): string
    {
        $interval=new \DateInterval('P90D');
        $characteristicDate=$this->getCreateData();
        $endDate=date_add($characteristicDate,$interval);
        $countDays = date_create('now')->diff($endDate)->days;
        if ($countDays >0)
        {
            $result='Актуальна '.$this->daysCountString($countDays);
        }
        else
        {
            $result='Не актуальна';
        }

        return $result;
    }
    public function checkValidationBool(): bool
    {
        $interval=new \DateInterval('P90D');
        $characteristicDate=$this->getCreateData();
        $endDate=date_add($characteristicDate,$interval);
        $countDays = date_create('now')->diff($endDate)->days;
        if ($countDays >0)
        {
            $result=true;
        }
        else
        {
            $result=false;
        }

        return $result;
    }



    public function setContent(?string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(?array $answers): self
    {
        $this->answers = $answers;

        return $this;
    }
}
