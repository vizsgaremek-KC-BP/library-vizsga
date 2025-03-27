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
      this.db.getStudentBook().subscribe(data => {
        this.bookArray = data;
        console.log(this.bookArray);
      });
    
      this.db.getMyLoans().subscribe(data => {
        this.loanArray = data.loans || [];
        console.log(this.loanArray);
      });
    }
    book: any = null;
    created_at: any = null;
    id: number = 0;
    inventory_number: string = '';
    status: string = '';
    updated_at: any = null;
    user_edu_id: number = 0;

    selectedBook: any = null;
    selectedLoan: any = null;
    
    loanArray:any[] = [];
    bookArray: any[] = [];
  
    ngOnInit(): void {}

    getBookByInventoryNumber(inventory_number: string) {
      const book = this.bookArray.find(book => book.inventory_number === inventory_number);
      return book?.book_type || null;
    }
   
    returnBook(id:string): void{
      this.db.returnBook(id).subscribe(
        data => {
          console.log('Könyv visszaadva', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a könyv visszaadásakor', error);
        }
      );
    }
}