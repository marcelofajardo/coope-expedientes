<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Caffeinated\Shinobi\Models\Role;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Auth;
use Image;

class ProfileController extends Controller
{

  public function index()
  {
      $profiles = Profile::paginate();

      return view('profiles.index', compact('profiles'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      $usuario = Auth::user()->id;
      //$profile = Profile::where('user_id', $usuario)->get();

      return view('profiles.create', [
          'usuario' => $usuario,
        ]);
  }

  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
      $data = $request->all();

      $creada = false;
      if($data['files'])
      {
            $allowedfileExtension=['jpeg','JPEG', 'pdf','jpg','png','docx','JPG','PDF','PNG','DOCX'];
            $files = $data['files'];
            foreach($files as $file){
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {
                    $destinationPath = 'img/profile/';
                    //$new_file = Image::make($file)->resize(300,300);
                    $img = Image::make($file->getRealPath());

                    $img->resize(100, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$filename);
                    //$new_file->move($destinationPath, $filename);
                    $data['user_id'] = Auth::user()->id;
                    $data['avatar'] = $destinationPath . $filename;
                    $creada = Profile::create($data);
                  }
            }
            if ($creada)
            {
                Session::flash('message-success', 'Perfil guardado satisfactoriamente.');
                return redirect()->route('profile.index');
            }else{
              Session::flash('message-warnning', 'Ocurrió un error al guardar.');
              return redirect()->route('profile.index');
            }
      }else{
          $data['user_id'] = Auth::user()->id;
          $creada = Profile::create($data);
          if ($creada)
          {
              Session::flash('message-success', 'Perfil guardado satisfactoriamente.');
              return redirect()->route('profile.index');
          }else{
            Session::flash('message-warnning', 'Ocurrió un error al guardar.');
            return redirect()->route('profile.index');
          }
      }

  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Profile $profile)
  {
      return view('profiles.show', compact('profile'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Profile $profile)
  {
    return view('profiles.edit', [
        'profile' => $profile,
      ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Profile $profile)
  {
      $data = $request->all();

      if($data['files'])
      {
            $allowedfileExtension=['jpeg','JPEG', 'pdf','jpg','png','docx','JPG','PDF','PNG','DOCX'];
            $files = $data['files'];
            foreach($files as $file)
            {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $check=in_array($extension,$allowedfileExtension);

                if($check)
                {
                    $destinationPath = 'img/profile/';
                    //$base = base64_encode($file);
                    //$img = Image::make($base)->save($file->getRealPath());
                    //$new_file = Image::make($file)->resize(300,300);
                    $img = Image::make($file->getRealPath());

                    $img->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.$filename);
                    //$new_file->move($destinationPath, $filename);
                    //dd($data);
                    $profile->nombre = $data['nombre'];
                    $profile->apellido = $data['apellido'];
                    $profile->telefono = $data['telefono'];
                    $data['user_id'] = Auth::user()->id;
                    $data['avatar'] = $destinationPath . $filename;
                    $profile->user_id = $data['user_id'];
                    $profile->avatar = $data['avatar'];
                    $updated = $profile->save();
                    if ($updated)
                    {
                        Session::flash('message-success', 'Perfil guardado satisfactoriamente.');
                        return view('profiles.edit', ['profile' => $profile]);
                    }else{
                      Session::flash('message-warnning', 'Ocurrió un error al guardar.');
                      return redirect()->route('profile.index');
                    }
                }
            }

      }else{
            $actualizado = $profile->fill($profileRequest->all())->update();
            if ($actualizado){
              Session::flash('message-success', 'Perfil guardado satisfactoriamente.');
              return redirect()->route('profile.index');
            }else{
              Session::flash('message-warnning', 'Ocurrió un error al guardar.');
              return redirect()->route('profile.index');
            }
      }



  }

  public function destroy(Profile $profile)
  {
    $profile->delete();
    Session::flash('message-danger', 'Perfil eliminado satisfactoriamente.');
    return redirect()->route('profile.index');
  }


}
