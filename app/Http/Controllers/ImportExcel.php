<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Article;
use Excel;

class ImportExcel extends Controller
{
    
	/**

     * Return View file

     *

     * @var array

     */
	public function importExport()
		{
			return view('importExport');
		}


/**

* File Export Code

*

* @var array

*/

	public function downloadExcel(Request $request, $type)
	{
		$data = Article::get()->toArray();
		return Excel::create('Article_List', function($excel) use ($data) {
		$excel->sheet('mySheet', function($sheet) use ($data)
		{
		$sheet->fromArray($data);
		});
		})->download($type);
	}


/**

* Import file into database Code

*

* @var array

*/

public function importExcel(Request $request)
{

if($request->hasFile('import_file')){
$path = $request->file('import_file')->getRealPath();

$data = Excel::load($path, function($reader) {})->get();

if(!empty($data) && $data->count()){
$extension = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);
if ($extension == 'ods'){
	foreach ($data->toArray() as $key => $value) {
	if(!empty($value)){
		foreach ($value as $v) {	
		$insert[] = ['title' => $v['title'], 'description' => $v['description'],'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s')];
		}
	}
}

} 
else {
foreach ($data->toArray() as $key => $value) {
		$insert[] = ['title' => $value['title'], 'description' => $value['description'],'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s')];
	}
}



	if(!empty($insert)){
		Article::insert($insert);
		return back()->with('success','Insert Record successfully.');
	}


}


}


return back()->with('error','Please Check your file, Something is wrong there.');

}
}
