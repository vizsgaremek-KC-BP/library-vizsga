import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LibraryListUserComponent } from './library-list-user.component';

describe('LibraryListUserComponent', () => {
  let component: LibraryListUserComponent;
  let fixture: ComponentFixture<LibraryListUserComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [LibraryListUserComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(LibraryListUserComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
