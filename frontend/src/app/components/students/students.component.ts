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
    email: string = '';
    name: string = '';
    edu_id: string = '';
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
      email: '',
      email_verified_at: '',
      password: '',
      edu_id: '',
      role: '',
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
          }
        );
        console.log('Kérlek, töltsd ki az összes mezőt.');
    }

    setSelectedStudent(student: any) {
      this.selectedStudent = { ...student }; 
    }
  
    modifyStudent(id: string, name: string, email: string, edu_id: string): void{
      this.db.updateStudent(id, name, email, edu_id).subscribe(
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
