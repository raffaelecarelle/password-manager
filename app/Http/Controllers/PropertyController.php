<?php

    namespace App\Http\Controllers;

    use App\Property;
    use Illuminate\Http\Request;

    class PropertyController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index ()
        {
            //
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

            $property = Property::create($request->all());

            return response()->json([
                'property' => $property,
                'message'  => 'Properietà creata con successo!'
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
        public function update (Request $request, Property $property)
        {
            $this->validate($request, [
                'name' => 'required|max:255'
            ]);

            $property->name = request('name');
            $property->description = request('description');
            $property->save();

            return response()->json([
                'message' => 'Properietà modificato con successo!'
            ], 200);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy (Property $property)
        {
            $property->delete();

            return response()->json([
                'message' => 'Properietà cancellata con successo!'
            ], 200);
        }

        public function getCredentials ($id)
        {
            $property = Property::find($id);
            $credentials = $property->credentials()->get();

            return response()->json([
                'credentials' => $credentials
            ], 200);
        }
    }
