import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { NamesService } from '../names.service';
import { ObjectUtils } from 'src/app/utilities/object-utils.util';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private user: object = null;
  private isUserAuthenticated = false;

  constructor(private http: HttpClient) { 
    this.user = JSON.parse(localStorage.getItem('user'));
    this.isUserAuthenticated = !!this.user;
  }

  checkIfUserIsAuthenticated(): boolean {
    return this.isUserAuthenticated;
  }

  login(user) {
    this.http.post(`${NamesService.URL}/login`, user).subscribe((response:any) => {
      if(this.isUserAuthenticated = response.success) {
        this.user = response.data;
        localStorage.setItem('user', JSON.stringify(this.user));
      }
    })
  }

  logout() {
    this.user = {};
    this.isUserAuthenticated = false;
    localStorage.removeItem('user');
  }

  getUser():any {
    return ObjectUtils.clone(this.user);
  }
}
