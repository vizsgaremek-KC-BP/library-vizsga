import { Component, Input, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { Router } from '@angular/router';
import { LogInComponent } from '../log-in/log-in.component';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-library-list-user',
  templateUrl: './library-list-user.component.html',
  styleUrl: './library-list-user.component.css'
})
export class LibraryListUserComponent implements OnInit {
  userName = "";
    constructor(
      public auth: AuthenticationService, 
      private router: Router, 
      loginComp:LogInComponent,
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService) {
      
      this.userName = localStorage.getItem('userName') || '';
      //localStorage.clear();

      if (!this.auth.isLoggedIn()) {
        this.router.navigate(['/login']);
      }
      db.getStudentBook().subscribe(data => {
        this.bookArray = data;
        console.log(this.bookArray);
      });
      // this.translate.setDefaultLang('en');
      // this.translate.use('en');
    }
    id: number = 0;
    inventory_number_base: string = '';
    title: string = '';
    author: string = '';
    price: number = 0;
    copies: number = 0;
    selectedBook: any = null;
  
    
  bookArray: any[] = [];
    @Input() books!: any;
    editBooks: boolean = false;
    titles: any = {};
  
    
    switchLanguage(lang: string) {
      this.translate.use(lang);
    }
  
    ngOnInit(): void {}
  
    setSelectedBook(book: any) {
      this.selectedBook = { ...book }; 
    }
  
    returnBook(id:string): void{
      this.db.returnBook(id).subscribe(
        data => {
          console.log('Könyv törölve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a könyv törlésekor', error);
        }
      );
    }
}