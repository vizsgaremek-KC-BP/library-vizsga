import { Component, Input, OnInit } from '@angular/core';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-assign-book',
  templateUrl: './assign-book.component.html',
  styleUrl: './assign-book.component.css'
})
export class AssignBookComponent implements OnInit {

    id: number = 0;
    inventory_number: string = '';
    user_id: string = '';
    title: string = '';
    author: string = '';
    price: number = 0;
    copies: number = 0;
    selectedLoan: any = null;
    loan:any;
    book: any;
    student: any;
  

  bookArray: any[] = [];
  studentArray: any[] = [];
  assignArray: any[] = [];

  setEditLoan() {
    this.editLoans = !this.editLoans;
  }
    @Input() Loans!: any;
    editLoans: boolean = false;
    titles: any = {};
  
    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      db.getBook().subscribe(data => {
        this.bookArray = data;
        console.log(this.bookArray);
      });
      db.getStudent().subscribe(data => {
        this.studentArray = data;
        console.log(this.studentArray);
      });
      // this.translate.setDefaultLang('en');
      // this.translate.use('en');
    }
    // switchLanguage(lang: string) {
    //   this.translate.use(lang);
    // }

    // setSelectedLoan(loan: any) {
    //   this.selectedLoan = { ...loan }; 
    // }
  
    ngOnInit(): void {}
  
    createLoan(): void {
      this.db.addLoan().subscribe(
        data => {
          console.log('Könyv hozzáadva', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a könyv hozzáadása közben', error);
        }
      );
      console.log('Kérlek, töltsd ki az összes mezőt.');
  }

}
