import { Component } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';
import { LogInComponent } from '../log-in/log-in.component';

@Component({
  selector: 'app-library-list',
  templateUrl: './library-list.component.html',
  styleUrl: './library-list.component.css'
})
export class LibraryListComponent {
  userName = "";
  constructor(public auth: AuthenticationService, private router: Router, loginComp:LogInComponent) {
    this.userName = localStorage.getItem('userName') || '';

    if (!this.auth.isLoggedIn()) {
      //this.router.navigate(['/login']);
    }
  }


}
