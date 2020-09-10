import { Component, ViewChild } from '@angular/core';
import { NavController, Platform, Slides } from 'ionic-angular';
import { TabsPage } from '../tabs/tabs';
import { Storage } from '@ionic/storage';
import { PushService } from '../../services/push_service';
import { APIService } from '../../services/api_service';
import { RestaurantsPage } from '../catalog/restaurants/restaurants';
import { CategoriesPage } from '../catalog/categories/categories';

/**
 * WelcomePage component
 */
@Component({
  templateUrl: 'welcome.html'
})

export class Welcome {
  public signup = false;

  @ViewChild(Slides) slidesElement: Slides;
  public sliderEnded = false;
  public direction = 'ltr';

  public slides = [];

  constructor(private nav: NavController,
              private storage: Storage,
              private platform: Platform,
              private push: PushService,
              private api: APIService
  ) {
    this.signup = (this.api.getSettings().signup_required == 1);
    this.direction = this.platform.dir();

    this.slides = [
      {
        'icon': 'assets/icon/welcome-icon1.svg',
        'title': 'ابحث عن مطعمك المفضل',
        // 'subTitle': '1',
      },
      // {
      //   'icon': 'assets/icon/welcome-icon2.svg',
      //   'title': 'اختر وجبتك المفضلة',
      //   // 'subTitle': '2',
      // },
      // {
      //   'icon': 'assets/icon/welcome-icon3.svg',
      //   'title': 'اطلب في اسرع واسهل طريقة',
      //   // 'subTitle': '3',
      // },
      // {
      //   'icon': 'https://snaxify.com/bg.svg',
      //   'title': 'نص ساعة والاكل عندك ;)',
      //   // 'subTitle': '4',
      // },
    ];
  }

  goToSignup() {
    this.nav.setRoot('SignupPage');
  }

  goToLogin() {
    this.nav.setRoot('LoginPage');
  }

  startApp() {
    this.push.init(this.api.getSettings().pushwoosh_id);
    // disabled to show welcome everytime
    // this.storage.set('welcomeShown', '1').then(() => {
    // }, () => {
    // });
    // FIXME: if changed does not direct  with tabs
    // no need for change to restaurants page and fix restaurant page without tabs problem in tabs.ts
    this.nav.setRoot(TabsPage);
    // StatusBar.styleDefault();
    // StatusBar.overlaysWebView(false);
    // StatusBar.backgroundColorByHexString('F8F8F8');
    // StatusBar.show();
  }

  previousSlide() {
    if (!this.slidesElement.isBeginning()) {
      this.slidesElement.slidePrev();
    }
  }

  nextSlide() {
    if (this.slidesElement.isEnd()) {
      this.sliderEnded = true;
    } else {
      this.slidesElement.slideNext();
    }
  }
}
