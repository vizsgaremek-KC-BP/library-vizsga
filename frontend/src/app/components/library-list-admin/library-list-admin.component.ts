import { Component, Input } from '@angular/core';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-library-list-admin',
  templateUrl: './library-list-admin.component.html',
  styleUrl: './library-list-admin.component.css'
})
export class LibraryListAdminComponent {

    id: number = 0;
    inventory_number: string = '';
    title: string = '';
    author: string = '';
    price: number = 0;
    copies: number = 0;
    selectedLoan: any = null;
    loan:any;
  
    loanArray: any[] = [];

    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      db.getLoans().subscribe(data => {
        this.loanArray = data;
        console.log(this.loanArray);
      });
      // this.translate.setDefaultLang('en');
      // this.translate.use('en');
    }
    // switchLanguage(lang: string) {
    //   this.translate.use(lang);
    // }
  
    ngOnInit(): void {}

  setSelectedLoan(loan: any) {
    this.selectedLoan = { ...loan }; 
  }

  approveLoan(id:string): void{
    this.db.approveLoan(id).subscribe(
      data => {
        console.log('Könyv törölve', data);
        window.location.reload();
      },
      error => {
        console.error('Hiba történt a könyv törlésekor', error);
      }
    );
  }

  forceApproveLoan(id:string): void{
    this.db.forceApproveLoan(id).subscribe(
      data => {
        console.log('Könyv törölve', data);
        window.location.reload();
      },
      error => {
        console.error('Hiba történt a könyv törlésekor', error);
      }
    );
  }

  rejectLoan(id:string): void{
    this.loanArray.forEach(element => {
      if(element.id == id){
        this.loan = element;
      }
    });
    this.db.rejectLoan(this.loan).subscribe(
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
