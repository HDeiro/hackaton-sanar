import { Component, OnInit } from '@angular/core';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Title } from '@angular/platform-browser';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/api/auth/auth.service';

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.scss']
})
export class MainComponent implements OnInit {

  routes: Array<{label: string, path: string}> = [
    {label: 'Prescription', path: '/prescription'},
    {label: 'Users', path: '/user'},
  ];
  filter = '';
  pageTitle = 'AnGolar';
  isHandset$: Observable<boolean> = this.breakpointObserver
    .observe(Breakpoints.Handset)
    .pipe(map(result => result.matches));

  constructor(
    private breakpointObserver: BreakpointObserver,
    private titleService: Title,
    private router: Router,
    private authService: AuthService) {}

  ngOnInit() {
    this.router.events.subscribe(() => 
      this.pageTitle = this.titleService.getTitle());
  }

  getFilteredRoutes() {
    return this.routes.filter(route => route.label.toLowerCase().indexOf(this.filter.toLowerCase()) >= 0);
  }

  doLogout() {
    this.authService.logout();
  }
}
