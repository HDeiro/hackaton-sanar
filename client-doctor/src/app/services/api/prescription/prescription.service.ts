import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { NamesService } from '../names.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PrescriptionService {

  constructor(
    private http: HttpClient
  ) { }

  getPatients() {
    return this.http.get<any>(`${NamesService.URL}/user?onlyPatient=1`);
  }

  savePrescription(prescription:any): Observable<any> {
    return this.http.post<any>(`${NamesService.URL}/prescription`, prescription);
  }
}
