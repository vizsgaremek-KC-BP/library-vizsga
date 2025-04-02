import { Component, Input, OnInit } from '@angular/core';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html',
  styleUrl: './users.component.css'
})
export class UsersComponent implements OnInit {
    id: number = 0;
    name: string = '';
    email: string = '';
    email_verified_at: string = '';
    password: string = '';
    edu_id: string = '';
    role: string = '';
    status: string = '';
    remember_token: string = '';
    created_at: string = '';
    updated_at: string = '';

    selectedUser: any = null;

    userArray: any[] = [];
    filteredUsers: any[] = [];
    searchText: string = '';

  setEditUser() {
    this.editUsers = !this.editUsers;
  }
    @Input() user!: any;
    editUsers: boolean = false;
    titles: any = {};
  
    modifiedUser: any = {
      id: 0,
      name: '',
      email: '',
      email_verified_at: '',
      password: '',
      edu_id: '',
      role: '',
      status: '',
      remember_token: '',
      created_at: '',
      updated_at: '',
    };
  
    constructor(
      private db: HttpService,
      private config: ConfigService,
      private translate: TranslateService
    ) {
      db.getUser().subscribe(data => {
        this.userArray = data;
        this.filteredUsers = [];
        // console.log(this.userArray);
      });
    }
  
    ngOnInit(): void {}

    translateStatus(status: string): string {
      const key = status === 'active' ? 'users.aktív' : 'users.inaktív';
      return this.translate.instant(key);
    }

    translateRole(role: string): string {
      const key = role === 'student' ? 'users.diák' : 'users.rendszergazda';
      return this.translate.instant(key);
    }

    filterUsers() {
      if (!this.searchText) {
        this.filteredUsers = [];
        return;
      }
      const searchLower = this.searchText.toLowerCase();
    
      this.filteredUsers = this.userArray.filter(user =>
        Object.values(user).some(val =>
          val?.toString().toLowerCase().includes(searchLower)
        )
      );
    }
  
    createUser(): void {
        this.db.addUser(this.name, this.email, this.edu_id, this.password).subscribe(
          data => {
            console.log('Felhasználó hozzáadva', data);
            window.location.reload();
          },
          error => {
            console.error('Hiba történt a felhasználó hozzáadása közben', error);
          }
        );
        console.log('Kérlek, töltsd ki az összes mezőt.');
    }

    setSelectedUser(user: any) {
      this.selectedUser = { ...user }; 
    }
    
    modifyUser(id: string, name: string, email: string, role: string): void {
      this.db.updateUser( id, name, String(email), role).subscribe(
        data => {
          console.log('Felhasználó frissítve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a felhasználó frissítésekor', error);
        }
      );
    }

    statusUser(id: string, currentStatus: string): void {
      const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
  
      this.db.statusSwitchUser(id, newStatus).subscribe(
          data => {
              console.log('Felhasználó státusza frissítve', data);
              this.userArray = this.userArray.map(user =>
                  user.id === id ? { ...user, status: newStatus } : user
              );
              window.location.reload();
          },
          error => {
              console.error('Hiba történt a státusz frissítésekor', error);
          }
      );
    }

}
