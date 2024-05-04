<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrainingRequest;
use App\Http\Requests\UpdateTrainingRequest;
use App\Models\Training;
use App\Models\TrainingTemplate;
use App\Models\User;
use App\View\Components\Admin\Training\CreateTraining as CreateTrainingComponent;
use App\View\Components\Admin\Training\CreateTrainingByTemplate as CreateTrainingByTemplateComponent;
use App\View\Components\Admin\Training\Training as TrainingComponent;
use App\View\Components\Admin\Training\Trainings as TrainingsComponent;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

class TrainingAdminController extends Controller
{
    /**
     * @return Renderable
     */
    public function index(): Renderable
    {
        $builder = (new Training())->newQuery()
            ->with([
                'instructor',
            ]);

        if (Auth::user()->role === UserRole::INSTRUCTOR->value) {
            $builder->where('instructor_id', '=', Auth::id());
        }

        $trainings = $builder
            ->orderByDesc('id')
            ->get();

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $trainingsComponent = new TrainingsComponent($trainings, $instructors);

        return $trainingsComponent->render()->with($trainingsComponent->data());
    }

    /**
     * @param int $id
     * @return Renderable
     */
    public function show(int $id): Renderable
    {
        /** @var Training $training */
        $training = (new Training())->newQuery()
            ->with([
                'instructor',
                'reservations',
            ])
            ->findOrFail($id);

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $trainingComponent = new TrainingComponent(
            $training,
            $instructors,
        );

        return $trainingComponent->render()->with($trainingComponent->data());

    }

    /**
     * @return Renderable
     */
    public function create(): Renderable
    {
        $trainingTemplates = (new TrainingTemplate())->newQuery()
            ->get();

        $createTrainingComponent = new CreateTrainingComponent($trainingTemplates);

        return $createTrainingComponent->render()->with($createTrainingComponent->data());
    }

    /**
     * @param Request $request
     * @return Renderable
     */
    public function createByTemplate(Request $request): Renderable
    {
        if (null === $trainingTemplateId = $request->get('id')) {
            throw new InvalidArgumentException('toje loh', 322);
        }

        /** @var TrainingTemplate $trainingTemplate */
        $trainingTemplate = (new TrainingTemplate())->newQuery()
            ->findOrFail($trainingTemplateId);

        $instructors = (new User())->newQuery()
            ->where('role', '=', UserRole::INSTRUCTOR->value)
            ->get();

        $createTrainingByTemplateComponent = new CreateTrainingByTemplateComponent(
            $trainingTemplate,
            $instructors,
        );

        return $createTrainingByTemplateComponent->render()->with($createTrainingByTemplateComponent->data());
    }

    /**
     * @param StoreTrainingRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(StoreTrainingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if (!isset($data['datetime_end'])) {
            $duration = $data['duration'];
            $datetimeStart = DateTime::createFromFormat('Y-m-d\TH:i', $data['datetime_start']);
            $data['datetime_end'] = $datetimeStart->add(new DateInterval('PT' . $duration . 'H'));
            unset($data['duration']);
        }

        (new Training())->newQuery()
            ->create($data);

        return redirect()->to(route('admin.trainings.index'));
    }

    /**
     * @param int $id
     * @param UpdateTrainingRequest $request
     * @return RedirectResponse
     */
    public function update(int $id, UpdateTrainingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        (new Training())->newQuery()
            ->findOrFail($id)
            ->update($data);

        return redirect()->to(route('admin.trainings.show', ['id' => $id]));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        (new Training())->newQuery()
            ->findOrFail($id)
            ->delete();

        return redirect()->to(route('admin.trainings.index'));
    }
}
