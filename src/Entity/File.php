<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\EntityInterface;
use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

#[ORM\Entity(repositoryClass: FileRepository::class)]
#[ORM\Table(name: 'files')]
class File implements EntityInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    protected int $id;

    #[ORM\Column(type: "string")]
    protected string $path;

    #[ORM\Column(type: "string")]
    protected string $originalFileName;

    #[ORM\Column(type: "uuid")]
    protected Uuid $uuidFileName;

    #[ORM\Column(type: "string")]
    protected string $extension;

    #[ORM\Column(type: "integer")]
    protected int $size;

    #[ORM\Column(type: "string", nullable: true)]
    protected ?string $mimeType = null;

    #[ORM\Column(name:"`order`", type: "integer", nullable: true, options: ['unsigned' => true])]
    protected ?int $order = null;

    #[ORM\Column(type: "boolean", options: ['default' => false])]
    protected bool $isUsed;

    #[ORM\ManyToOne(inversedBy: 'files')]
    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: false)]
    private ?Conversion $conversion = null;

    public function __construct()
    {
        $this->uuidFileName = UuidV4::v4();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getOriginalFileName(): ?string
    {
        return $this->originalFileName;
    }

    public function setOriginalFileName(string $originalFileName): self
    {
        $this->originalFileName = $originalFileName;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function gerOrder(): ?int
    {
        return $this->order;
    }

    public function setOrder(?int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function isUsed(): bool
    {
        return $this->isUsed;
    }

    public function setUsed(bool $isUsed): void
    {
        $this->isUsed = $isUsed;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function getIsUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function setIsUsed(bool $isUsed): self
    {
        $this->isUsed = $isUsed;

        return $this;
    }

    public function isIsUsed(): ?bool
    {
        return $this->isUsed;
    }

    public function getConversion(): ?Conversion
    {
        return $this->conversion;
    }

    public function setConversion(?Conversion $conversion): static
    {
        $this->conversion = $conversion;

        return $this;
    }

    public function getUuidFileName(): string
    {
        return $this->uuidFileName->toRfc4122();
    }

    public function setUuidFileName(Uuid $uuidFileName): void
    {
        $this->uuidFileName = $uuidFileName;
    }
}
