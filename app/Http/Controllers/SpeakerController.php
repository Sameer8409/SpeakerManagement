<?php

namespace App\Http\Controllers;

use App\Speaker;
use Illuminate\Http\Request;
use Validator;
use Image;

class SpeakerController extends Controller
{
    public function __construct(Speaker $speaker)
    {
        $this->speaker = $speaker;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $result = $this->speaker->orderBy('created_at', 'desc')->paginate(10);
        $paginate = $result->toArray();
        
        return view('speakers-list', compact('response','result','paginate'));
    }



    public function showCards()
    {
        $client = new \GuzzleHttp\Client();
        $accessToken = 'Fj0Hbfcx6rJI0drr';
        
        $response = $client->GET("http://localhost:8000/api/show", ['headers' => [
            'Authorization' => $accessToken
        ]]);

        $category_all = json_decode($response->getBody()->getContents(),true);
        $data = $category_all['data'];
        // dd($data);  
        return view('users-list', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add-speakers');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // dd($request->all(), $imageName, base64_decode($image));
        $messages = [
            'mimes' => 'not a image',
        ];
        if($request->file('images'))
        {
            $rules = [
                'name'  => 'required|max:30 | regex:/^[\pL\s\-]+$/u',
                'email' =>  'required|unique:speakers,email|email',
                'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'designation' => 'required | regex:/^[\pL\s\-]+$/u',
                'description' => 'required',
            ];
        }else{
            $rules = [
                'name'  => 'required|max:30 | regex:/^[\pL\s\-]+$/u',
                'email' =>  'required|unique:speakers,email|email',
                'designation' => 'required | regex:/^[\pL\s\-]+$/u',
                'description' => 'required',
            ];
        }
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {    
            return response()->json($validator->errors(), 422);
        }

        $speaker = $this->speaker->create([
            'name' => $request->name,
            'email'=> $request->email,
            'designation' => $request->designation,
            'description' => $request->description

        ]);

        if($speaker)
        {
            if($request->croped_image != "undefined")
            {
                $image = $request->croped_image;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = str_random(10).'.'.'png';
                \File::put(public_path('/images').'/'.$imageName, base64_decode($image));
                
                $img = Image::make(base64_decode($image));
                
                $img->resize(50, 50, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/thumbnail').'/'.$imageName);
                $images = Speaker::find($speaker->id);
                
                $status = $images->update([
                    'images' => $imageName,
                ]);
                
            }
            elseif($request->file('images'))
            {
                if ($validator->fails()) {    
                    return response()->json($validator->errors(), 422);
                }
                $images = array();
                $images = $request->file('images');
                $this->imageHandling($images, $speaker->id);                
            }
            
            return response()->json([
                'data' => $speaker,
                'status' => 200,
                'error' => false,
                'message' => 'Speaker added successfully'
            ]); 
            // return redirect(url('speakers'))->with('success','Speaker added successfully');
            
        }else{
            return response()->json([
                'message' => 'There is some error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $result = $this->speaker->find($id);
        return view('edit-speakers', compact('result'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'required' => 'required.',
        ];
        $rules = [
            'name'  => 'required|max:30 | regex:/^[\pL\s\-]+$/u',
            'email' =>  'required|email|unique:speakers,email,'.$id,
            'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'designation' => 'required | regex:/^[\pL\s\-]+$/u',
            'description' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {    
            return response()->json($validator->errors(), 422);
        }

        // $request->validate([
        //     'name'  => 'required|max:30 | regex:/^[\pL\s\-]+$/u',
        //     'email' =>  'required|email|unique:speakers,email,'.$id,
        //     'images.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'designation' => 'required | regex:/^[\pL\s\-]+$/u',
        //     'description' => 'required',
        // ]);

        $speaker = $this->speaker->where('id',$id)->update([
            'name' => $request->name,
            'email'=> $request->email,
            'designation' => $request->designation,
            'description' => $request->description,
        ]);

        if($request->croped_image != "undefined")
        {
            $image = $request->croped_image;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = str_random(10).'.'.'png';
            \File::put(public_path('/images').'/'.$imageName, base64_decode($image));
            
            $img = Image::make(base64_decode($image));
            
            $img->resize(50, 50, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/thumbnail').'/'.$imageName);
            $images = Speaker::find($id);
            
            $status = $images->update([
                'images' => $imageName,
            ]);
            
        }elseif($request->file('images'))
        {
            $images = array();
            $images = $request->file('images');
            $this->imageHandling($images, $id);
        }
            
        if($speaker){
            return response()->json([
                'data' => $speaker,
                'status' => 200,
                'error' => false,
                'message' => 'Speaker updated successfully'
            ]); 
            // return redirect(url('speakers'))->with('success','Speaker added successfully');
            
        }else{
            return response()->json([
                'message' => 'There is some error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
        $speaker = Speaker::find($id);
        $speaker->delete();
        if($speaker)
        {
            return response()->json([
                'data' => $speaker,
                'success' => 'Record has been deleted successfully!'
            ]);
        }
        // return Redirect(url('speakers'))->with('success', 'Successfully deleted the record!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Speaker  $speaker
     * @return \Illuminate\Http\Response
     */
    
    // public function deleteImage(Request $request, $id)
    // {
    //     $speaker = Speaker::find($id);
    //     $rest_img = explode( ',',$speaker->images);
    //     foreach($rest_img as $t)
    //     {
            
    //     }
    //     dd($speaker->images,$request->img, $rest_img);   
    //     return Redirect(url('speakers'))->with('success', 'Successfully deleted the record!');

    // }

    
    /**
     * Handling Images
     */

    public function imageHandling($data, $id)
    {
        if (count($data) && is_array($data)) 
        {
             $str = str_random(5,1000);
            foreach($data as $image)
            {
                $names=$image->getClientOriginalName();
                
                $fileName = $str .  mt_rand(100, 1000) . '.' . $names;

                $img = Image::make($image->getRealPath());
                
                $img->resize(110, 75, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/thumbnail').'/'.$fileName);

                $img->resize(150, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail2').'/'.$fileName);

                $img->resize(315, 205, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail3').'/'.$fileName);

                $img->resize(455, 305, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail4').'/'.$fileName);

                $img->resize(500, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail5').'/'.$fileName);

                $img->resize(620, 375, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail6').'/'.$fileName);

                $img->resize(1050, 700, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail7').'/'.$fileName);

                $img->resize(1300, 975, function ($constraint) {
                    $constraint->aspectRatio();
                })->save( public_path('/thumbnail8').'/'.$fileName);


                $destinationPath = public_path('/images');
                
                $image->move($destinationPath, $fileName);

                $imagesNames[] = $fileName;
            }

            $imagesNames = implode(",", $imagesNames);

            $images = Speaker::find($id);
            $status = $images->update([
                'images' => $imagesNames,
            ]);
        }
    }

}

