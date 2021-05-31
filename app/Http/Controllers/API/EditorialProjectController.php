<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditorialProjectDestroyRequest;
use App\Http\Requests\EditorialProjectIndexRequest;
use App\Http\Requests\EditorialProjectShowRequest;
use App\Http\Requests\EditorialProjectStoreRequest;
use App\Http\Requests\EditorialProjectUpdateRequest;
use App\Http\Requests\EditorialProjectUploadFileRequest;
use App\Http\Resources\EditorialProjectResource;
use App\Models\EditorialProject;
use App\Models\EditorialProjectTranslation;
use App\Models\Media;
use App\Models\Role;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class EditorialProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param EditorialProjectIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(EditorialProjectIndexRequest $request)
    {

        $per_page = $request->query('per_page') ?: 15;

        $editorial_projects = EditorialProject::query();

        if (!Auth::user()->isAdmin()) {
            $editorial_projects->byUserRole(Auth::user()->roleKey());
        }

        // Filter by text
        if ($text = $request->query('text')) {
            $editorial_projects->where(function ($query) use ($text) {
                $query->where('title', 'like', '%' . $text . '%');
            });
        }

        // Filter by trashed
        if ($request->has('trashed')) {
            switch ($request->query('trashed')) {
                case 'with':
                    $editorial_projects->withTrashed();
                    break;
                case 'only':
                    $editorial_projects->onlyTrashed();
                    break;
                default:
                    $editorial_projects->withTrashed();
            }
        }

        $editorial_projects = $editorial_projects->paginate((int)$per_page);

        // Include relationship
        if ($request->has('with')) {
            $editorial_projects->load($request->query('with'));
        }

        return EditorialProjectResource::collection($editorial_projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EditorialProjectStoreRequest $request
     * @return EditorialProjectResource
     * @throws Exception
     */
    public function store(EditorialProjectStoreRequest $request): EditorialProjectResource
    {

        DB::beginTransaction();

        try {
            $editorial_project = new EditorialProject();
            $editorial_project->publication_date = $request->publication_date;
            $editorial_project->pages = $request->pages;
            $editorial_project->price = $request->price;
            $editorial_project->cost = $request->cost;
            $editorial_project->sector_id = $request->sector_id;
            $editorial_project->author_id = $request->has('author_id') ? $request->author_id : Auth::id();
            $editorial_project->save();

            if ($request->has('title')) {
                $editorial_project->setTranslation($request->title, EditorialProjectTranslation::FIELD_TITLE, App::getLocale());
            }

            DB::commit();
        } catch (Exception $exception) {

            DB::rollBack();
            throw $exception;
        }

        return new EditorialProjectResource($editorial_project);
    }

    /**
     * Display the specified resource.
     *
     * @param EditorialProjectShowRequest $request
     * @param EditorialProject $editorial_project
     * @return EditorialProjectResource
     */
    public function show(EditorialProjectShowRequest $request, EditorialProject $editorial_project): EditorialProjectResource
    {
        // Include relationship
        if ($request->query('with')) {
            $editorial_project->load($request->query('with'));
        }

        return new EditorialProjectResource($editorial_project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditorialProjectUpdateRequest $request
     * @param EditorialProject $editorial_project
     * @return EditorialProjectResource
     * @throws Exception
     */
    public function update(EditorialProjectUpdateRequest $request, EditorialProject $editorial_project): EditorialProjectResource
    {

        DB::beginTransaction();

        try {

            $editorial_project->update($request->only(['sector_id']));

            if ($request->has('title')) {
                $editorial_project->setTranslation($request->title, EditorialProjectTranslation::FIELD_TITLE, App::getLocale());
            }
            $role_key = Auth::user()->roleKey();

            if (!Auth::user()->isAdmin() && $editorial_project->userRoleCanUpdateFlags($role_key)) {
                switch ($role_key) {
                    case Role::ROLE_CEO:
                        $editorial_project->update($request->only(['is_approved_by_ceo']));
                        break;
                    case Role::ROLE_EDITORIAL_DIRECTOR:
                        $editorial_project->update($request->only(['is_approved_by_editorial_director']));
                        break;
                    case Role::ROLE_SALES_DIRECTOR:
                        $editorial_project->update($request->only(['is_approved_by_sales_director']));
                        break;
                    case Role::ROLE_EDITORIAL_RESPONSIBLE:
                        $editorial_project->update($request->only(['is_approved_by_editorial_responsible']));
                        break;
                    default:
                        abort(403, 'Invalid Role');
                }
            }

            DB::commit();
        } catch (Exception $exception) {

            DB::rollBack();
            throw $exception;
        }

        return new EditorialProjectResource($editorial_project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EditorialProjectDestroyRequest $request
     * @param EditorialProject $editorial_project
     * @return Response
     */
    public function destroy(EditorialProjectDestroyRequest $request, EditorialProject $editorial_project): Response
    {
        $editorial_project->delete();

        return response(null, 204);
    }


    /**
     * @param EditorialProjectUploadFileRequest $request
     * @param $id
     * @return Application|ResponseFactory|Response
     * @throws Exception
     */
    public function uploadFile(EditorialProjectUploadFileRequest $request, $id)
    {

        $editorial_project = EditorialProject::findOrFail($id);

        $editorial_project->saveMedia($request->file('file'), Auth::id() . '.' . $request->file->extension());

        // Get File
        //$contents = Storage::get('files/1.pdf');

        //return $contents;

        // Salva file
        //$path = Storage::putFile('files', $request->file('file'));


        // Delete file
        //Storage::delete('files/1.pdf');

        // Delete directory
        //Storage::deleteDirectory('files');


        return response(null, 204);
    }
}
