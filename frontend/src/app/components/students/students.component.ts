import { Component, Input, OnInit } from '@angular/core';
import { HttpService } from '../../services/http.service';
import { ConfigService } from '../../services/config.service';
import { TranslateService } from '@ngx-translate/core';

@Component({
  selector: 'app-students',
  templateUrl: './students.component.html',
  styleUrl: './students.component.css'
})
export class StudentsComponent implements OnInit {
    id: number = 0;
    name: string = '';
    email: string = '';
    edu_id: string = '';
    password: string = '';
    role: string = '';
    selectedStudent: any = null;

    studentArray: any[] = [];

  setEditStudent() {
    this.editStudents = !this.editStudents;
  }
    @Input() student!: any;
    editStudents: boolean = false;
    titles: any = {};
  
    modifiedStudent: any = {
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
      db.getStudent().subscribe(data => {
        this.studentArray = data;
        console.log(this.studentArray);
      });
      // this.translate.setDefaultLang('en');
      // this.translate.use('en');
    }
    switchLanguage(lang: string) {
      this.translate.use(lang);
    }
  
    ngOnInit(): void {
        
      }
    
  
    createStudent(): void {
        this.db.addStudent(this.name, this.email, this.edu_id).subscribe(
          data => {
            console.log('Diák hozzáadva', data);
            window.location.reload();
          },
          error => {
            console.error('Hiba történt a diák hozzáadása közben', error);
            console.error('Részletes hiba:', error.error);
          }
        );
        console.log('Kérlek, töltsd ki az összes mezőt.');
    }

    setSelectedStudent(student: any) {
      this.selectedStudent = { ...student }; 
    }
    // setSelectedStudent(student: any): void {
    //   this.selectedStudent = { ...student }; // Make sure to clone the student object
    // }
  
    // modifyStudent(id: string, edu_id: string, email: string, name: string): void{
    //   this.db.updateStudent(id, edu_id, email, name, this.password, this.role).subscribe(
    //     data => {
    //       console.log('Diák frissítve', data);
    //       window.location.reload();
    //     },
    //     error => {
    //       console.error('Hiba történt a diák frissítésekor', error);
    //     }
    //   );
    // }
    modifyStudent(id: string, name: string, email: string, role: string): void {
      this.db.updateStudent(id, email, name, role).subscribe(
        data => {
          console.log('Diák frissítve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a diák frissítésekor', error);
        }
      );
    }
    
  
    deleteStudent(id: string): void{
      this.db.deleteStudent(id).subscribe(
        data => {
          console.log('Diák törölve', data);
          window.location.reload();
        },
        error => {
          console.error('Hiba történt a diák törlésekor', error);
        }
      );
    }
}
