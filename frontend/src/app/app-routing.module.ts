import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { LogInComponent } from './components/log-in/log-in.component';
import { AboutComponent } from './components/about/about.component';
import { RegistrationComponent } from './components/registration/registration.component';
import { LibraryListUserComponent } from './components/library-list-user/library-list-user.component';
import { LibraryListAdminComponent } from './components/library-list-admin/library-list-admin.component';
import { BooksComponent } from './components/books/books.component';
import { StudentsComponent } from './components/students/students.component';
import { AssignBookComponent } from './components/assign-book/assign-book.component';

const routes: Routes = [
  { path: '', component: HomeComponent },
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LogInComponent },
  { path: 'register', component: RegistrationComponent },
  { path: 'about', component: AboutComponent },
  { path: 'books', component: BooksComponent },
  { path: 'students', component: StudentsComponent },
  { path: 'libraryUser', component: LibraryListUserComponent },
  { path: 'libraryAdmin', component: LibraryListAdminComponent },
  { path: 'assignBook', component: AssignBookComponent },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
