import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrl: './nav-bar.component.css'
})
export class NavBarComponent implements OnInit {
  isLoggedIn: boolean = false;

  ngOnInit(): void {
    this.isLoggedIn = this.auth.isLoggedIn();
  }

  public logOut() {
    this.auth.logout();
  }
  constructor(public auth: AuthenticationService) {}
}
