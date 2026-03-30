مثال payload:

{
 "sub": 1,
 "iat": 1710000000,
 "exp": 1710003600
}

شرح:

iat = وقت الإنشاء
exp = وقت الانتهاء

السيرفر يقارن:

current_time > exp

إذا true:

token expired






    public function create(CreateCourseDTO $dto)
    {
        return DB::transaction(function () use ($dto) {

            // $dto->teacher_id = auth()->id();
            // $course = $this->courseRepository->create($dto->toArray());

            $course = $this->courseRepository->create([
                'title' => $dto->title,
                'description' => $dto->description,
                'prix' => $dto->prix,
                'teacher_id' => auth()->id(),
            ]);

            if (!empty($dto->interest_ids)) {    
                $course->interests()->attach($dto->interest_ids);
            }

            return $course;
        });
    }
controller
    public function store(StoreCourseRequest $request)
    {
        $dto = CreateCourseDTO::fromRequest($request);
        $course = $this->courseService->create($dto);
        return response()->json([
            'message' => 'Course created successfully.',
            'course' => new CourseResource($course),
        ]);
    }