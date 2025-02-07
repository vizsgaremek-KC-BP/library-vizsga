import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { LogInComponent } from './components/log-in/log-in.component';
import { AboutComponent } from './components/about/about.component';
import { LibraryListComponent } from './components/library-list/library-list.component';
import { RegistrationComponent } from './components/registration/registration.component';

const routes: Routes = [
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LogInComponent },
  { path: 'about', component: AboutComponent },
  { path: 'library', component: LibraryListComponent },
  { path: 'register', component: RegistrationComponent }

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
