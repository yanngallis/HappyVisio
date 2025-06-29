<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $lastLoginAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $blockedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastChangePasswordAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $inactiveReminderAt = null;

    #[ORM\Column(length: 1)]
    private ?string $gender = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, unique:true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address2 = null;

    #[ORM\Column(length: 5)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $birthYear = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resetToken = null;

    #[ORM\Column(nullable: true)]
    private ?int $numberOfTry = null;

    #[ORM\Column]
    private ?bool $isBlocked = null;

    #[ORM\Column]
    private ?bool $isDeleted = null;

    #[ORM\Column]
    private ?bool $isBanned = null;

    #[ORM\Column]
    private ?bool $isForceChangePassword = null;

    #[ORM\Column]
    private ?bool $isForceComplexPassword = null;

    #[ORM\Column]
    private ?bool $isMailUpcomingRDV = null;

    #[ORM\Column]
    private ?bool $isMailRegistrationConfirmation = null;

    #[ORM\Column]
    private ?bool $isMailReminder24Hours = null;

    #[ORM\Column]
    private ?bool $isMailReminder1Hour = null;

    #[ORM\Column]
    private ?bool $isMailPostActivity = null;

    #[ORM\Column]
    private ?bool $isMailNewsletter = null;

    #[ORM\Column]
    private ?bool $isSMSReminder1Hour = null;

    public function __construct()
    {
        $this->numberOfTry = 0;
        $this->isBlocked = false;
        $this->isDeleted = false;
        $this->isForceChangePassword = false;
        $this->isForceComplexPassword = false;
        $this->isMailUpcomingRDV = true;
        $this->isMailRegistrationConfirmation = true;
        $this->isMailReminder24Hours = true;
        $this->isMailReminder1Hour = true;
        $this->isMailPostActivity = true;
        $this->isMailNewsletter = false;
        $this->isSMSReminder1Hour = true;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->lastLoginAt = new \DateTimeImmutable();
        $this->lastChangePasswordAt = new \DateTimeImmutable();

        $slugger = new AsciiSlugger('fr');
        $this->slug = $slugger->slug($this->firstname . ' ' . $this->lastname . ' ' . uniqid());
    }

    #[ORM\PreUpdate]
    public function preUpdate(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(\DateTimeImmutable $lastLoginAt): static
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    public function getBlockedAt(): ?\DateTimeImmutable
    {
        return $this->blockedAt;
    }

    public function setBlockedAt(\DateTimeImmutable $blockedAt): static
    {
        $this->blockedAt = $blockedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getLastChangePasswordAt(): ?\DateTimeImmutable
    {
        return $this->lastChangePasswordAt;
    }

    public function setLastChangePasswordAt(?\DateTimeImmutable $lastChangePasswordAt): static
    {
        $this->lastChangePasswordAt = $lastChangePasswordAt;

        return $this;
    }

    public function getInactiveReminderAt(): ?\DateTimeImmutable
    {
        return $this->inactiveReminderAt;
    }

    public function setInactiveReminderAt(?\DateTimeImmutable $inactiveReminderAt): static
    {
        $this->inactiveReminderAt = $inactiveReminderAt;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getPhoneNumber(?string $phoneNumber = null): ?string
    {
        if ($this->phoneNumber) {
            $phoneNumber = str_replace(' ', '', $this->phoneNumber);
            return trim(strrev(chunk_split(strrev($phoneNumber), 2, ' ')));
        }

        return $phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): static
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getBirthYear(): ?int
    {
        return $this->birthYear;
    }

    public function setBirthYear(int $birthYear): static
    {
        $this->birthYear = $birthYear;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): static
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    public function getNumberOfTry(): ?int
    {
        return $this->numberOfTry;
    }

    public function setNumberOfTry(?int $numberOfTry): static
    {
        $this->numberOfTry = $numberOfTry;

        return $this;
    }

    public function isIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(bool $isBlocked): static
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function isIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function isIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): static
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function isIsForceChangePassword(): ?bool
    {
        return $this->isForceChangePassword;
    }

    public function setIsForceChangePassword(bool $isForceChangePassword): static
    {
        $this->isForceChangePassword = $isForceChangePassword;

        return $this;
    }

    public function isIsForceComplexPassword(): ?bool
    {
        return $this->isForceComplexPassword;
    }

    public function setIsForceComplexPassword(bool $isForceComplexPassword): static
    {
        $this->isForceComplexPassword = $isForceComplexPassword;

        return $this;
    }

    public function isIsMailUpcomingRDV(): ?bool
    {
        return $this->isMailUpcomingRDV;
    }

    public function setIsMailUpcomingRDV(bool $isMailUpcomingRDV): static
    {
        $this->isMailUpcomingRDV = $isMailUpcomingRDV;

        return $this;
    }

    public function isIsMailRegistrationConfirmation(): ?bool
    {
        return $this->isMailRegistrationConfirmation;
    }

    public function setIsMailRegistrationConfirmation(bool $isMailRegistrationConfirmation): static
    {
        $this->isMailRegistrationConfirmation = $isMailRegistrationConfirmation;

        return $this;
    }

    public function isIsMailReminder24Hours(): ?bool
    {
        return $this->isMailReminder24Hours;
    }

    public function setIsMailReminder24Hours(bool $isMailReminder24Hours): static
    {
        $this->isMailReminder24Hours = $isMailReminder24Hours;

        return $this;
    }

    public function isIsMailReminder1Hour(): ?bool
    {
        return $this->isMailReminder1Hour;
    }

    public function setIsMailReminder1Hour(bool $isMailReminder1Hour): static
    {
        $this->isMailReminder1Hour = $isMailReminder1Hour;

        return $this;
    }

    public function isIsMailPostActivity(): ?bool
    {
        return $this->isMailPostActivity;
    }

    public function setIsMailPostActivity(bool $isMailPostActivity): static
    {
        $this->isMailPostActivity = $isMailPostActivity;

        return $this;
    }

    public function isIsMailNewsletter(): ?bool
    {
        return $this->isMailNewsletter;
    }

    public function setIsMailNewsletter(bool $isMailNewsletter): static
    {
        $this->isMailNewsletter = $isMailNewsletter;

        return $this;
    }

    public function isIsSMSReminder1Hour(): ?bool
    {
        return $this->isSMSReminder1Hour;
    }

    public function setIsSMSReminder1Hour(bool $isSMSReminder1Hour): static
    {
        $this->isSMSReminder1Hour = $isSMSReminder1Hour;

        return $this;
    }

    public function getInitials(): string
    {
        if ($this->firstname && $this->lastname) {
            return substr($this->firstname, 0, 1) . substr($this->lastname, 0, 1);
        }

        return '';
    }

    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getPseudoOrFirstname(): string
    {
        if ($this->firstname) {
            return ($this->pseudo) ? : $this->firstname;
        }

        return '';
    }
}
