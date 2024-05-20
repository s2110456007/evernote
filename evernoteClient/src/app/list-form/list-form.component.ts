import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule, FormArray, FormControl } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { EvernoteService } from '../shared/evernote.service'; // Adjust path as necessary
import { User } from '../shared/user';
import { List } from '../shared/list';

@Component({
  selector: 'app-list-form',
  standalone: true,
  imports: [ ReactiveFormsModule ],
  templateUrl: './list-form.component.html',
  styles: ``
})
export class ListFormComponent implements OnInit {
  listForm: FormGroup;
  list = new List(0, '', 0,  new User(0, '', '', ''), []);
  isUpdatingList = false;

  constructor(
    private fb: FormBuilder,
    private es: EvernoteService,
    private route: ActivatedRoute,
    private router: Router
  ) {
    this.listForm = this.fb.group({
      id: [''],
      name: ['']
    });
  }

  ngOnInit(): void {
    const listId = this.route.snapshot.params['id'];
    if (listId) {
      this.isUpdatingList = true;
      this.es.getSingleList(listId).subscribe(list => {
        this.list = list;
        this.initForm();
      });
    } else {
      this.initForm();
    }
  }

  initForm(): void {
    this.listForm = this.fb.group({
      id: [this.list.id],
      name: [this.list.name, Validators.required],
    });
  }

  submitForm(): void {
    if (this.listForm.valid) {
      if (this.isUpdatingList) {
        this.es.updateList(this.listForm.value).subscribe(() => {
          this.router.navigate(['/lists']);
        });
      } else {
        this.es.createList(this.listForm.value).subscribe(() => {
          this.router.navigate(['/lists']);
        });
      }
    }
  }
}
