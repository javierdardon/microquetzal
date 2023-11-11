<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankAccountsInfoCollection;
use App\Models\About;
use App\Models\ConfigurationSocial;
use App\Models\ConfigurationHero;
use App\Models\ConfigurationFinalFrame;
use App\Models\BuildComponentCategories;
use App\Models\BankAccountsInfo;
use App\Models\Category;
use App\Http\Resources\GamaCollection;
use App\Models\Gama;
use App\Models\Build;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AdminConfigurationController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Configuration/Index');
    }

    // *hero
    public function heroIndex()
    {
        $hero = ConfigurationHero::find(1);

        return Inertia::render('Admin/Configuration/Hero/Index',['hero' => $hero]);
    }

    public function heroUpdate(Request $request)
    {

        $validated = $request->validate([
            'message1' => 'nullable|string|max:23',
            'message2' => 'nullable|string|max:12',
            'message3' => 'nullable|string|max:23',
            'message4' => 'nullable|string|max:12',
        ]);

        $hero = ConfigurationHero::find(1);

        $path = '';

        if ( empty($request->image) ) {
            $path = $hero->image;
        } else {
            $path = public_path('hero/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $imageName = time() . '.' . $request->image[0]['file']->extension();
            $request->image[0]['file']->move($path, $imageName);
            $path = "hero/{$imageName}";
        }

        $configurationHero = ConfigurationHero::find(1);
        $configurationHero->update([
            'message1' => $request->message1,
            'message2' => $request->message2,
            'message3' => $request->message3,
            'message4' => $request->message4,
            'image'    => $path,
        ]);

        return to_route('admin.configurations.heroIndex')->with(['success' => 'Actualizado correctamente']);
    }

    public function heroDefault(Request $request)
    {
        $configurationHero = ConfigurationHero::find(1);
        $configurationHero->update([
                'message1'=> 'MICRO QUETZAL',
                'message2'=> 'NACIONAL',
                'message3'=> 'LAS MEJORES',
                'message4'=> 'PC GAMING',
                'image'=> 'default/hero.svg',
        ]);

        return to_route('admin.configurations.index')->with(['success' => 'Restaurado Correctamente']);
    }

    //*final frame
    public function FinalFrameIndex()
    {
        $finalFrame = ConfigurationFinalFrame::find(1);

        return Inertia::render('Admin/Configuration/FinalFrame/Index',['finalFrame' => $finalFrame]);
    }

    public function FinalFrameUpdate(Request $request)
    {

        $validated = $request->validate([
            'message1' => 'nullable|string|max:42',
            'message2' => 'nullable|string|max:27',
        ]);


        $finalFrame = ConfigurationFinalFrame::find(1);

        $path = '';

        if ( empty($request->image) ) {
            $path = $finalFrame->image;
        } else {
            $path = public_path('finalFrame/');
            !is_dir($path) &&
                mkdir($path, 0777, true);

            $imageName = time() . '.' . $request->image[0]['file']->extension();
            $request->image[0]['file']->move($path, $imageName);
            $path = "finalFrame/{$imageName}";
        }

        $configurationFinalFrame = ConfigurationFinalFrame::find(1);
        $configurationFinalFrame->update([
            'message1'=> $request->message1,
            'message2'=> $request->message2,
            'image'=> $path,
        ]);

        return to_route('admin.configurations.finalFrameIndex')->with(['success' => 'Actualizado Correctamente']);
    }

    public function FinalFrameDefault(Request $request)
    {
        $configurationFinalFrame = ConfigurationFinalFrame::find(1);
        $configurationFinalFrame->update([
                'message1'=> 'UNETE AL MUNDO DEL PC GAMING',
                'message2'=> 'MICRO QUETZAL NACIONAL',
                'image'=> 'default/finalFrame.svg',
        ]);

        return to_route('admin.configurations.index')->with(['success' => 'Restaurado Correctamente']);
    }

    // *social links
    public function socialLinksIndex()
    {
        $social = ConfigurationSocial::find(1);
        return Inertia::render('Admin/Configuration/SocialLinks/Index',['social' => $social]);
    }

    public function socialLinksUpdate(Request $request)
    {   
        $validated = $request->validate([
            'facebook'=> 'nullable|string|max:65534',
            'whatsapp' => 'nullable|string|max:65534',
            'gmail' => 'nullable|string|max:65534',
            'twitter' => 'nullable|string|max:65534',
            'instagram' => 'nullable|string|max:65534',
            'tikTok' => 'nullable|string|max:65534',
        ]);

        $configurationSocial = ConfigurationSocial::find(1);
        $configurationSocial->update($request->all());

        return to_route('admin.configurations.socialLinksUpdate')->with(['success' => 'Actualizado correctamente']);
    }

    // *about
    public function aboutIndex()
    {
        $about = About::find(1);
        return Inertia::render('Admin/Configuration/About/Index',['about' => $about]);
    }

    public function aboutUpdate(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required',
        ]);
        
        $about = About::find(1);
        $about->update([
            'body'=> $request->body,
        ]);
        return to_route('admin.configurations.aboutIndex')->with(['success' => 'Operación Exitosa']);
    }




    //* BuildComponentCategories
    public function BuildComponentCategoriesIndex()
    {
        if(!BuildComponentCategories::find(1)) {
            BuildComponentCategories::create([
                'cpu' => null,
                'cooler' => null,
                'ram' => null,
                'gpu' => null,
                'psu' => null,
                'mobo' => null,
                'case' => null,
                'rom' => null,
            ]);
        }

        $buildComponentCategories = BuildComponentCategories::find(1);
        $categories = Category::all();
        return Inertia::render('Admin/Configuration/BuildComponentCategories/Index',
        [
            'buildComponentCategories' => $buildComponentCategories,
            "categories" => $categories,
        ]);
    }

    public function BuildComponentCategoriesUpdate(Request $request)
    {
        $validated = $request->validate([
            'cpu' => 'required|numeric',  
            'cooler' => 'required|numeric',
            'ram' => 'required|numeric', 
            'gpu' => 'required|numeric', 
            'psu' => 'required|numeric', 
            'mobo' => 'required|numeric',
            'case' => 'required|numeric',
            'rom' => 'required|numeric', 
        ]);
        
        $buildComponentCategories = BuildComponentCategories::find(1);
        $buildComponentCategories->update($request->all());

        return to_route('admin.configurations.buildComponentCategories.index')->with(['success' => 'Guardado Correctamente']);
    }

    //*bank accounts info
    public function bankAccountsIndex(Request $request)
    {
        $paginateItems = 7;

        //* QUERY PARAMS
        $search = $request->input('search');

        if ( isset($search) ) {
            //* VALIDATIONS:
            //* SEARCHER:
            $bankAccounts = new BankAccountsInfoCollection(BankAccountsInfo::when($search, function (Builder $query) use ( $search ) {
                $query->where('bank_name', 'like', '%'. $search .'%')->orWhere('account_name', 'like', '%'. $search .'%')->orWhere('account_number', 'like', '%'. $search .'%');
            })->paginate($paginateItems));
        } else {
            $bankAccounts = new BankAccountsInfoCollection(BankAccountsInfo::paginate(7));
        }

        // $bankAccounts = new BankAccountsInfoCollection(BankAccountsInfo::paginate(7));
        $bankAccounts->withpath('');
        return Inertia::render('Admin/Configuration/BankAccountsInfo/Index',['bankAccounts' => $bankAccounts]);
    }

    public function bankAccountsCreate()
    {
        return Inertia::render('Admin/Configuration/BankAccountsInfo/Create');
    }

    public function bankAccountsStore(Request $request)
    {

        $validated = $request->validate([
            'bankName' => 'required|string|max:64',
            'accountName' => 'required|string|max:86',
            'accountNumber' => 'required|string|max:64',
        ]);
        
        BankAccountsInfo::create([
            'bank_name' => $request->bankName,
            'account_name' => $request->accountName,
            'account_number' => $request->accountNumber
        ]);

        return to_route('admin.configurations.bankAccounts.index')->with(['success' => 'Creado Correctamente']);
    }

    public function bankAccountsDestroy(BankAccountsInfo $bankAccount)
    {   
        $bankAccount->delete();
        return back()->with(['success' => 'Eliminado Correctamente']); 
    }

    public function bankAccountsEdit( BankAccountsInfo $bankAccount ) {
        return Inertia::render('Admin/Configuration/BankAccountsInfo/Edit', [
            'bankAccount' => $bankAccount
        ]);
    }

    public function bankAccountsUpdate(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:64',
            'account_name' => 'required|string|max:86',
            'account_number' => 'required|string|max:64',
        ]);

        $bankAccount = BankAccountsInfo::find($request->id);
        $bankAccount->update($request->all());

        return to_route('admin.configurations.bankAccounts.index')->with(['success' => 'Actualizado Correctamente']);
    }
    
    //*bank accounts info


    //* Gamas
    public function gamasIndex()
    {
        if(!Gama::find(1)) {
            Gama::create([
                'name' => 'De entrada',
                'percentage' => 40,
            ]);
            Gama::create([
                'name' => 'Media',
                'percentage' => 55,
            ]);
            Gama::create([
                'name' => 'Media alta',
                'percentage' => 70,
            ]);
            Gama::create([
                'name' => 'Alta',
                'percentage' => 85,
            ]);
            Gama::create([
                'name' => 'Premium',
                'percentage' => 100,
            ]);
        }

        $gamas = new GamaCollection(Gama::orderBy('percentage')->get());
        return Inertia::render('Admin/Configuration/Gamas/Index',
        [
            'gamas' => $gamas,
        ]);
    }

    public function gamasCreate()
    {
        return Inertia::render('Admin/Configuration/Gamas/Create');
    }

    public function gamasEdit( Gama $gama ) {
        return Inertia::render('Admin/Configuration/Gamas/Edit', [
            'gama' => $gama
        ]);
    }

    public function gamasStore(Request $request)
    {   
        $validated = $request->validate([
            'name' => 'required|string|max:15|unique:App\Models\Gama,name',
            'percentage' => 'required|numeric|min:0|max:100'
        ]);
        
        Gama::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
        ]);

        return to_route('admin.configurations.gamas.index')->with(['success' => 'Creado Correctamente']);
    }

    public function gamasUpdate( Request $request )
    {
        $validated = $request->validate([
            'name' => 'required|string|max:15',
            'percentage' => 'required|numeric|min:0|max:100'
        ]);
        
        $gama = Gama::find($request->id);
        $gama->update($request->all());

        return to_route('admin.configurations.gamas.index')->with(['success' => 'Actualizado Correctamente']);
    }
 
    public function gamasDestroy( Gama $gama ) {

        if(Build::where('gama_id', $gama->id)->exists()){
            return back()->with(['error' => 'No se puede eliminar una Gama cuando está enlazada a un PC Combo']);
        }

        $gama->delete();
        return back()->with(['success' => 'Eliminado Correctamente']); 

    }
}
