import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { LogInComponent } from './components/log-in/log-in.component';
import { AboutComponent } from './components/about/about.component';
import { RegistrationComponent } from './components/registration/registration.component';
import { LibraryListUserComponent } from './components/library-list-user/library-list-user.component';
import { LibraryListAdministratorComponent } from './components/library-list-administrator/library-list-administrator.component';
import { LibraryListAdminComponent } from './components/library-list-admin/library-list-admin.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LogInComponent },
  { path: 'register', component: RegistrationComponent },
  { path: 'about', component: AboutComponent },
  { path: 'libraryUser', component: LibraryListUserComponent },
  { path: 'libraryAdministrator', component: LibraryListAdministratorComponent },
  { path: 'libraryAdmin', component: LibraryListAdminComponent },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
