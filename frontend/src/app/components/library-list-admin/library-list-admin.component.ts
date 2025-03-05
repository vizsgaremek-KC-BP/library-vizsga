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
    inventory_number_base: string = '';
    title: string = '';
    author: string = '';
    price: number = 0;
    copies: number = 0;
    selectedLoan: any = null;
  
    
  loanArray: any[] = [];
  setEditLoan() {
    this.editLoans = !this.editLoans;
  }
    @Input() Loans!: any;
    editLoans: boolean = false;
    titles: any = {};

    modifiedLoan: any = {
        id: 0,
        inventory_number_base: '',
        title: '',
        author: '',
        price: 0,
        copies: 0,
        created_at: '',
        updated_at: '',
    };
  
    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      db.getLoan().subscribe(data => {
        this.loanArray = data;
        console.log(this.loanArray);
      });
      // this.translate.setDefaultLang('en');
      // this.translate.use('en');
    }
    switchLanguage(lang: string) {
      this.translate.use(lang);
    }
  
    ngOnInit(): void {}
  
    
}
