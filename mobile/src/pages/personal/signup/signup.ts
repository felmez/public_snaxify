import { Component } from '@angular/core';
import { IonicPage, NavController, AlertController } from 'ionic-angular';
import { APIService } from '../../../services/api_service';
import { UtilService } from '../../../services/util_service';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TabsPage } from '../../tabs/tabs';
import { PushService } from '../../../services/push_service';
import { Storage } from '@ionic/storage';
import { TranslateService } from '@ngx-translate/core';
import firebase from 'firebase';



/**
 * Signup page component
 */
@IonicPage()
@Component({
  selector: 'page-signup',
  templateUrl: 'signup.html'
})
export class SignupPage {
  public loginForm: FormGroup;
  public active: boolean;
  public multipleCities = false;
  public cities: any[] = [];
  public recaptchaVerifier: firebase.auth.RecaptchaVerifier;
  constructor(
    private apiService: APIService,
    private nav: NavController,
    private builder: FormBuilder,
    private util: UtilService,
    private push: PushService,
    private storage: Storage,
    private translate: TranslateService,
    public alertCtrl: AlertController,
    public navCtrl: NavController
  ) {
    this.active = true;
    const fields = {
      // name: ['', Validators.required],
      phone: ['', Validators.required],
      // email: ['', [Validators.required, Validators.email]],
      // password: ['', Validators.required]
    };
    this.multipleCities = (this.apiService.getSettings().multiple_cities == 1);
    if (this.multipleCities) {
      fields['city_id'] = [null, Validators.required];
      this.cities = this.apiService.getCities();
    }
    this.loginForm = this.builder.group(fields);
  }

  doSignup() {
    this.util.showLoader();
    let data = JSON.parse(JSON.stringify(this.loginForm.value));
    this.apiService.signup(data).then(response => {
      this.util.hideLoader();
      if (response.success) {
        this.push.init(this.apiService.getSettings().pushwoosh_id);
        this.storage.set('welcomeShown', '1').then(() => {
        }, () => {
        });
        this.nav.setRoot(TabsPage);
      }
      else {
        this.util.alert(response.errors, '');
        console.log("fucked up")
      }
    }, (data) => {
      this.util.hideLoader();
      this.util.alert(this.translate.instant('signup.error'), '');
    });
  }

  login() {
    this.nav.setRoot('LoginPage');
  }



  ionViewDidLoad() {
    const config = {
      apiKey: "AIzaSyDqkm1f_Ge8ULGVZ7Zgk-8GhnVR3_xRP_E",
      authDomain: "snaxify-60464.firebaseapp.com",
      databaseURL: "https://snaxify-60464.firebaseio.com",
      projectId: "snaxify-60464",
      storageBucket: "snaxify-60464.appspot.com",
      messagingSenderId: "656908172865",
      appId: "1:656908172865:web:5616932669f0f7111f50c0",
      measurementId: "G-LBF8J91C18"
    };
    firebase.initializeApp(config);
    this.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {'size': 'invisible'});
  }


  signIn(phoneNumber: number) {
    const appVerifier = this.recaptchaVerifier;
    const phoneNumberString = "+" + phoneNumber;
    firebase.auth().signInWithPhoneNumber(phoneNumberString, appVerifier)
      .then(confirmationResult => {
        // SMS sent. Prompt user to type the code from the message, then sign the
        // user in with confirmationResult.confirm(code).
        let prompt = this.alertCtrl.create({
          title: 'Enter the Confirmation code',
          inputs: [{ name: 'confirmationCode', placeholder: 'Confirmation Code' }],
          buttons: [
            {
              text: 'Cancel',
              handler: data => { console.log('Cancel clicked'); }
            },
            {
              text: 'Send',
              handler: data => {
                confirmationResult.confirm(data.confirmationCode)
                  .then(function (result) {
                    // User signed in successfully.
                    console.log(result.user);
                    // ...
                  }).catch(function (error) {
                    // User couldn't sign in (bad verification code?)
                    // ...
                  });
              }
            }
          ]
        });
        prompt.present();
      })
      .catch(function (error) {
        console.error("SMS not sent", error);
      });

  }

}
