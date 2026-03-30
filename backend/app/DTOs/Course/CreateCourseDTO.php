<?php
namespace App\DTOs\Course;

class CreateCourseDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public float $prix,
        public array $interest_ids = []
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            $request->title,
            $request->description,
            $request->prix,
            $request->interest_ids ?? []
        );
    }
}