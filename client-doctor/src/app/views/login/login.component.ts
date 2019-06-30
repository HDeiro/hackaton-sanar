import { Component, OnInit } from '@angular/core';
import { FormErrorMatcher } from 'src/app/utilities/form-error-matcher.util';
import { FormControl, Validators } from '@angular/forms';
import { AuthService } from 'src/app/services/api/auth/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  userInfo = {
    email: 'testador@email.com', 
    password: '123456'
  };
  passwordRecoveryModeIsEnabled = false;
  passwordIsHidden = true;
  matcher = new FormErrorMatcher();
  formControl = new FormControl('', [
    Validators.required,
    Validators.email,
  ]);

  constructor(
    private authService: AuthService    
  ) { }

  doLogin() {
    this.authService.login(this.userInfo);
  }

  ngOnInit() {
  }

}
