import { Component } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';
import { LogInComponent } from '../log-in/log-in.component';

@Component({
  selector: 'app-library-list-user',
  templateUrl: './library-list-user.component.html',
  styleUrl: './library-list-user.component.css'
})
export class LibraryListUserComponent {
  userName = "";
    constructor(public auth: AuthenticationService, private router: Router, loginComp:LogInComponent) {
      this.userName = localStorage.getItem('userName') || '';
      //localStorage.clear();

      if (!this.auth.isLoggedIn()) {
        this.router.navigate(['/login']);
      }
    }
}