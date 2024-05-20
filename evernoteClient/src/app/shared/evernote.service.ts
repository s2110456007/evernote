import { Injectable } from '@angular/core';
import { List } from './list';
import { Observable, catchError, retry, throwError } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { User } from './user';
import { Note } from './note';
import { Tag } from './tag';
import { Todo } from './todo';

@Injectable({
  providedIn: 'root'
})
export class EvernoteService {

  private api:string = 'http://evernote.s2110456007.student.kwmhgb.at/api';
  constructor(private http:HttpClient){

  }

  //Lists-------------------------------------------------
  getAllLists() {
      return this.http.get<Array<List>>(`${this.api}/lists`)
        .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  getSingleList(id:string):Observable<List> {
    return this.http.get<List>(`${this.api}/lists/${id}`)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  removeList(id:string):Observable<any> {
    return this.http.delete<List>(`${this.api}/lists/${id}`)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  createList(list:List):Observable<any> {
    return this.http.post<List>(`${this.api}/lists`, list)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  updateList(list:List):Observable<any> {
    return this.http.put<List>(`${this.api}/lists/${list.id}`, list)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  //Notes-------------------------------------------------
  getSingleNote(id:string):Observable<Note> {
    return this.http.get<Note>(`${this.api}/notes/${id}`)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  removeNote(id:string):Observable<any> {
    return this.http.delete<Note>(`${this.api}/notes/${id}`)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  createNote(note:Note):Observable<any> {
    return this.http.post<Note>(`${this.api}/notes`, note)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  updateNote(note:Note):Observable<any> {
    return this.http.put<Note>(`${this.api}/notes/${note.id}`, note)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  getAddAbleTagsNote(id:string) {
    return this.http.get<Array<Tag>>(`${this.api}/addAbleTags/note/${id}`)
        .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  //Todos-------------------------------------------------
  getSingleTodo(id:string):Observable<Todo> {
    return this.http.get<Todo>(`${this.api}/todos/${id}`)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  removeTodo(id:string):Observable<any> {
    return this.http.delete<Todo>(`${this.api}/todos/${id}`)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  createTodo(note:Todo):Observable<any> {
    return this.http.post<Todo>(`${this.api}/todos`, note)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  updateTodo(todo:Todo):Observable<any> {
    return this.http.put<Todo>(`${this.api}/todos/${todo.id}`, todo)
      .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  getAddAbleTagsTodo(id:string) {
    return this.http.get<Array<Tag>>(`${this.api}/addAbleTags/todo/${id}`)
        .pipe(retry(3)).pipe(catchError(this.errorHandler));
  }

  private errorHandler(error:Error | any):Observable<any>{
    return throwError(error);
  }
}
