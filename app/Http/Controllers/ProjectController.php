<?php

    namespace App\Http\Controllers;

    use App\Project;
    use App\Property;
    use Illuminate\Http\Request;

    class ProjectController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index (Request $request)
        {
            if ($request->query('q') == "") {
                return response()->json([
                    'projects' => [],
                ], 200);
            }

            $projects = Project::where('name', 'like', '%' . $request->query('q') . '%')->get();
            return response()->json([
                'projects' => $projects,
            ], 200);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create ()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store (Request $request)
        {
            $this->validate($request, [
                'name' => 'required|max:255'
            ]);

            $project = Project::create([
                'name'        => request('name'),
                'description' => request('description')
            ]);

            return response()->json([
                'project' => $project,
                'message' => 'Progetto creato con successo!'
            ], 200);
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show ($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit ($id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update (Request $request, Project $project)
        {
            $this->validate($request, [
                'name' => 'required|max:255'
            ]);

            $project->name = request('name');
            $project->description = request('description');
            $project->save();

            return response()->json([
                'message' => 'Progetto modificato con successo!'
            ], 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy (Project $project)
        {
            $project->delete();

            return response()->json([
                'message' => 'Progetto cancellato con successo!'
            ], 200);
        }

        public function getProperties ($project_id)
        {
            $project = Project::find($project_id);
            $properties = $project->properties()->get();

            return response()->json([
                'properties' => $properties
            ], 200);
        }
    }
