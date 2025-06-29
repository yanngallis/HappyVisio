<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;
    private string $email = "john@doe.com";
    private string $password = "password";
    private string $firstname = "John";
    private string $pseudo = "JohnD";
    private string $lastname = "Doe";
    private string $gender = "m";
    private string $phoneNumber = "0606060606";
    private string $postalCode = "75000";
    private int $birthYear = 1960;

    protected function setUp(): void
    {
        $this->user = new User();
        $this->user->setEmail($this->email)
            ->setPassword($this->password)
            ->setFirstname($this->firstname)
            ->setLastname($this->lastname)
            ->setGender($this->gender)
            ->setPhoneNumber($this->phoneNumber)
            ->setPostalCode($this->postalCode)
            ->setBirthYear($this->birthYear)
        ;
    }

    public function testUserTrue(): void
    {
        $formatedPhoneNumber = trim(strrev(chunk_split(strrev(str_replace(' ', '', $this->user->getPhoneNumber())), 2, ' ')));

        $this->assertTrue($this->user->getEmail() === $this->email);
        $this->assertTrue($this->user->getPassword() === $this->password);
        $this->assertTrue($this->user->getFirstname() === $this->firstname);
        $this->assertTrue($this->user->getLastname() === $this->lastname);
        $this->assertTrue($this->user->getGender() === $this->gender);
        $this->assertTrue($this->user->getPhoneNumber() === $formatedPhoneNumber);
        $this->assertTrue($this->user->getPostalCode() === $this->postalCode);
        $this->assertTrue($this->user->getBirthYear() === $this->birthYear);
        $this->assertTrue($this->user->getFullName() === $this->firstname . ' ' . $this->lastname);
        $this->assertTrue($this->user->getPseudoOrFirstname() === $this->firstname);

        $this->user->setPseudo($this->pseudo);
        $this->assertTrue($this->user->getPseudoOrFirstname() === $this->pseudo);
    }

    public function testUserFalse(): void
    {
        $formatedPhoneNumber = trim(strrev(chunk_split(strrev(str_replace(' ', '', $this->user->getPhoneNumber())), 2, ' ')));

        $this->assertFalse($this->user->getEmail() !== $this->email);
        $this->assertFalse($this->user->getPassword() !== $this->password);
        $this->assertFalse($this->user->getFirstname() !== $this->firstname);
        $this->assertFalse($this->user->getLastname() !== $this->lastname);
        $this->assertFalse($this->user->getGender() !== $this->gender);
        $this->assertFalse($this->user->getPhoneNumber() !== $formatedPhoneNumber);
        $this->assertFalse($this->user->getPostalCode() !== $this->postalCode);
        $this->assertFalse($this->user->getBirthYear() !== $this->birthYear);
        $this->assertFalse($this->user->getFullName() !== $this->firstname . ' ' . $this->lastname);
        $this->assertFalse($this->user->getPseudoOrFirstname() !== $this->firstname);

        $this->user->setPseudo($this->pseudo);
        $this->assertFalse($this->user->getPseudoOrFirstname() !== $this->pseudo);
    }
}
