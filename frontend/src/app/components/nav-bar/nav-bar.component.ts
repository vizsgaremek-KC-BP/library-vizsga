import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { ConfigService } from '../../services/config.service';

@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrl: './nav-bar.component.css'
})
export class NavBarComponent implements OnInit {
  menuOpen: boolean = false;

  toggleMenu() {
      this.menuOpen = !this.menuOpen;
  }
  closeMenu() {
    this.menuOpen = false;
  }

  currentLang: string = 'hu';

  isLoggedIn: boolean = false;

  constructor(public auth: AuthenticationService, private configService: ConfigService) {}

  switchLanguage(language: string) {
    this.currentLang = language;
    this.configService.switchLanguage(language);
  }

  ngOnInit(): void {
    this.isLoggedIn = this.auth.isLoggedIn();
  }

  public logOut() {
    this.auth.logout();
  }
}
