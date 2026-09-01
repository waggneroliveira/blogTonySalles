<?php

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PopUpController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ReportController;
use App\Repositories\AuditCountRepository;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Repositories\SettingThemeRepository;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\FormIndexController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\SettingEmailController;
use App\Http\Controllers\SettingThemeController;
use App\Http\Controllers\AuditActivityController;
use App\Http\Controllers\Auth\PasswordEmailController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('painel/', function () {
    return redirect()->route('admin.dashboard.painel');
});

Route::prefix('painel/')->group(function () {
    Route::get('login', function () {
        return view('admin.auth.login');
    })->name('admin.dashboard.painel');

    Route::get('/success-logout', function () {
        return view('admin.success.success-logout');
    })->name('success-logout');

    Route::post('login.do', [AuthController::class, 'authenticate'])
    ->name('admin.user.authenticate');

    /*=====================REDEFINICAO DE SENHA=========================*/

    // Rota para exibir o formulário "Esqueci a senha"
    Route::get('password/reset', function(){
        return view('admin.auth.recover-password');
    })->name('password.request');

    // Rota para processar o formulário "Esqueci a senha"
    Route::post('/password/email', [PasswordEmailController::class, 'passwordEmail'])
    ->name('password.email');

    // Rota para exibir o formulário de redefinição de senha
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
    
    // Rota para processar a redefinição de senha
    Route::post('/password/reset', [ResetPasswordController::class, 'processPasswordReset'])
    ->name('password.update');
    
    Route::get('/send-success', [PasswordEmailController::class, 'showSuccess'])
    ->name('send-success');

    Route::get('/password-success-reset', function () {
        return view('emails.password-success-reset');
    })->name('success-reset-password');

    /*=====================FINAL REDEFINICAO DE SENHA=========================*/

    Route::middleware([Authenticate::class])->group(function(){ 
        Route::get('documentation', function () {
            return view('admin.documentation.introduction');
        })->name('admin.dashboard.documentation.introduction');

        Route::get('/loading', function () {
            return view('admin.loadPage.loading');
        })->name('loading');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::resource('pop-up', PopUpController::class)
        ->names('admin.dashboard.popUp')
        ->parameters(['pop-up'=>'popUp']);
        //AUDITORIA
        Route::resource('auditorias', AuditActivityController::class)
        ->names('admin.dashboard.audit')
        ->parameters(['auditorias'=>'activitie']);
        Route::post('auditorias/{id}/mark-as-read', [AuditActivityController::class, 'markAsRead']);
        Route::post('/auditorias/mark-all-as-read', [AuditActivityController::class, 'markAllAsRead']);
        //LEAD
        Route::resource('lead', FormIndexController::class)
        ->names('admin.dashboard.formIndex')
        ->parameters(['lead'=>'formIndex']);
        //CONTATO
        Route::resource('contato', ContactController::class)
        ->names('admin.dashboard.contact')
        ->parameters(['contato'=>'contact']);
        //NEWSLTTER
        Route::resource('newsletter', NewsletterController::class)
        ->names('admin.dashboard.newsletter')
        ->parameters(['newsletter'=>'newsletter']);
        Route::post('newsletter/delete', [NewsletterController::class, 'destroySelected'])
        ->name('admin.dashboard.newsletter.destroySelected');
        //ANUNCIO
        Route::resource('anuncio', AnnouncementController::class)
        ->names('admin.dashboard.announcement')
        ->parameters(['anuncio'=>'announcement']);
        Route::post('anuncio/delete', [AnnouncementController::class, 'destroySelected'])
        ->name('admin.dashboard.announcement.destroySelected');
        Route::post('anuncio/sorting', [AnnouncementController::class, 'sorting'])
        ->name('admin.dashboard.announcement.sorting');

        //BLOG
        Route::resource('blog', BlogController::class)
        ->parameters(['blog' => 'blog'])
        ->names('admin.dashboard.blog');
        Route::post('blog/delete', [BlogController::class, 'destroySelected'])
        ->name('admin.dashboard.blog.destroySelected');
        Route::post('blog/sorting', [BlogController::class, 'sorting'])
        ->name('admin.dashboard.blog.sorting');
        Route::post('blog/uploadImageCkeditor', [BlogController::class, 'uploadImageCkeditor'])
        ->name('admin.dashboard.blog.uploadImageCkeditor');
        //CATEGORIA BLOG
        Route::resource('categoria-do-blog', BlogCategoryController::class)
        ->parameters(['categoria-do-blog' => 'blogCategory'])
        ->names('admin.dashboard.blogCategory');
        Route::post('categoria-do-blog/delete', [BlogCategoryController::class, 'destroySelected'])
        ->name('admin.dashboard.blogCategory.destroySelected');
        Route::post('categoria-do-blog/sorting', [BlogCategoryController::class, 'sorting'])
        ->name('admin.dashboard.blogCategory.sorting');

        //REPORT
        Route::resource('sessao-anuncie', ReportController::class)
        ->names('admin.dashboard.report')
        ->parameters(['sessao-anuncie'=>'report']);

        //DIRECTION
        Route::resource('topico-sobre', DirectionController::class)
        ->parameters(['topico-sobre' => 'direction'])
        ->names('admin.dashboard.direction');
        Route::post('topico-sobre/delete', [DirectionController::class, 'destroySelected'])
        ->name('admin.dashboard.direction.destroySelected');
        Route::post('topico-sobre/sorting', [DirectionController::class, 'sorting'])
        ->name('admin.dashboard.direction.sorting');
        //VIDEO
        Route::resource('videos', VideoController::class)
        ->names('admin.dashboard.video')
        ->parameters(['videos'=>'video']);
        Route::post('videos/delete', [VideoController::class, 'destroySelected'])
        ->name('admin.dashboard.video.destroySelected');
        Route::post('videos/sorting', [VideoController::class, 'sorting'])
        ->name('admin.dashboard.video.sorting');
        //ABOUT
        Route::resource('sobre', AboutController::class)
        ->names('admin.dashboard.about')
        ->parameters(['sobre'=>'about']);
        Route::post('sobre/delete', [AboutController::class, 'destroySelected'])
        ->name('admin.dashboard.about.destroySelected');
        Route::post('sobre/sorting', [AboutController::class, 'sorting'])
        ->name('admin.dashboard.about.sorting');
        Route::post('blog/uploadImageCkeditorAbout', [AboutController::class, 'uploadImageCkeditorAbout'])
        ->name('admin.dashboard.about.uploadImageCkeditorAbout');
        //EVENT
        Route::resource('agenda', EventController::class)
        ->names('admin.dashboard.event')
        ->parameters(['agenda'=>'event']);
        Route::post('agenda/delete', [EventController::class, 'destroySelected'])
        ->name('admin.dashboard.event.destroySelected');
        Route::post('agenda/sorting', [EventController::class, 'sorting'])
        ->name('admin.dashboard.event.sorting');
        Route::post('agenda/store', [EventController::class, 'storeTheBlog'])
        ->name('admin.dashboard.event.storeTheBlog');

        //E-MAIL CONFIG
        Route::resource('configuracao-de-email', SettingEmailController::class)
        ->names('admin.dashboard.settingEmail')
        ->parameters(['configuracao-de-email' => 'settingEmail']);
        Route::post('configuracoes/smtp/verify', [SettingEmailController::class, 'smtpVerify'])->name('admin.dashboard.settingEmail.smtpVerify');
        //GRUPOS
        Route::resource('grupos', RoleController::class)
        ->names('admin.dashboard.group')
        ->parameters(['grupos' => 'role']);
        Route::post('grupos/delete', [RoleController::class, 'destroySelected'])
        ->name('admin.dashboard.group.destroySelected');
        //USUARIOS
        Route::resource('usuario', UserController::class)
        ->names('admin.dashboard.user')
        ->parameters(['usuario'=>'user']);
        Route::post('usuario/delete', [UserController::class, 'destroySelected'])
        ->name('admin.dashboard.user.destroySelected');
        Route::post('usuario/sorting', [UserController::class, 'sorting'])
        ->name('admin.dashboard.user.sorting');
        
        //DESATIVAR COMENTARIO
        Route::put('/desativa-comentario/{comment}', [CommentController::class, 'desactiveComment'])
        ->name('comment.desactive.update');
        //ATIVAR COMENTARIO
        Route::put('/ativar-comentario/{comment}', [CommentController::class, 'activeComment'])
        ->name('comment.active.update');
        //DELETAR COMENTARIO
        Route::delete('/deletar-comentario/{comment}', [CommentController::class, 'destroy'])
        ->name('comment.delete');

        // SETTINGS THEME
        Route::post('setting', [SettingThemeController::class, 'setting'])->name('admin.dashboard.settingTheme'); 
        Route::post('setting/update', [SettingThemeController::class, 'settingUpdate'])->name('admin.dashboard.settingThemeUpdate'); 
    });

    // LANGUAGES
    Route::get('/lang/{locale}', function (string $locale) {
        if (! in_array($locale, ['en', 'es', 'pt'])) {
            abort(400);
        }
        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect()->back();
    })->name('change.language');
    // LOGOUT
    Route::get('logout', [AuthController::class, 'logout'])->name('admin.dashboard.user.logout');
});

View::composer('admin.core.admin', function ($view) {
    $currentUser = Auth::user();
    $user = User::where('id', $currentUser->id)->active()->first();
    
    $notifications = (new AuditCountRepository());
    $auditorias = $notifications->allAudit();
    $auditCount = $notifications->auditCount();
    $settingTheme = (new SettingThemeRepository())->settingTheme();

    return $view->with('settingTheme', $settingTheme)->with('user', $user)->with('auditorias', $auditorias)->with('auditCount', $auditCount);
});
