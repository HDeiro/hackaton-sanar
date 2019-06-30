import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class NamesService {

  public static URL = 'https://api.sanar.hugodeiro.com/api/v1';

  constructor() { }
}
