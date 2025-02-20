import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LibraryListAdminComponent } from './library-list-admin.component';

describe('LibraryListAdminComponent', () => {
  let component: LibraryListAdminComponent;
  let fixture: ComponentFixture<LibraryListAdminComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [LibraryListAdminComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(LibraryListAdminComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
