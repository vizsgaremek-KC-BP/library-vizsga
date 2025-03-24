import { Component, Input } from '@angular/core';
import { HttpService } from '../../services/http.service';

@Component({
  selector: 'app-library-list-admin',
  templateUrl: './library-list-admin.component.html',
  styleUrl: './library-list-admin.component.css'
})
export class LibraryListAdminComponent {

    id: number = 0;
    inventory_number: string = '';
    edu_id: string = '';
    title: string = '';
    author: string = '';
    price: number = 0;
    copies: number = 0;
    selectedLoan: any = null;
    loan:any;
  
    loanArray: any[] = [];
    filteredLoans: any[] = [];
    searchText: string = '';

    constructor(
      private db: HttpService
    ) {
      db.getLoans().subscribe(data => {
        this.loanArray = data;
        this.filteredLoans = [];
        console.log(this.loanArray);
      });
    }
    
  
    ngOnInit(): void {}

    filterLoans() {
      if (!this.searchText) {
        this.filteredLoans = [];
        return;
      }
      const searchLower = this.searchText.toLowerCase();
  
      this.filteredLoans = this.loanArray.filter(loan =>
        Object.values(loan).some(val =>
          val?.toString().toLowerCase().includes(searchLower)
        )
      );
    }

  setSelectedLoan(loan: any) {
    this.selectedLoan = { ...loan }; 
  }

  createLoan(): void {
    this.db.addLoan(this.edu_id, this.inventory_number).subscribe(
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

  approveLoan(id:string): void{
    this.db.approveLoan(id).subscribe(
      data => {
        console.log('Könyv elfogadva', data);
        window.location.reload();
      },
      error => {
        console.error('Hiba történt a könyv elfogadásakor', error);
      }
    );
  }

  forceApproveLoan(id:string): void{
    this.db.forceApproveLoan(id).subscribe(
      data => {
        console.log('Könyv elfogadva', data);
        window.location.reload();
      },
      error => {
        console.error('Hiba történt a könyv elfogadásakor', error);
      }
    );
  }

  rejectLoan(id:string): void{
    this.db.rejectLoan(id).subscribe(
      data => {
        console.log('Könyv elutasítva', data);
        window.location.reload();
      },
      error => {
        console.error('Hiba történt a könyv elutasításakor', error);
      }
    );
  }
}
