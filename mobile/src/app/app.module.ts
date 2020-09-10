import { ErrorHandler, Injectable, Injector, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { BrowserModule } from '@angular/platform-browser';
import { HttpModule } from '@angular/http';
import { HttpClient, HttpClientModule } from '@angular/common/http';

import { Geolocation } from  '@ionic-native/geolocation';
import { NativeGeocoder } from '@ionic-native/native-geocoder';

import { MyApp } from './app.component';
import { TabsPage } from '../pages/tabs/tabs';
import { Loading } from '../pages/loading/loading';
import { Welcome } from '../pages/welcome/welcome';
import { GeoPage } from '../pages/geo/geo';

import { IonicStorageModule } from '@ionic/storage';
import { StatusBar } from '@ionic-native/status-bar';
import { SplashScreen } from '@ionic-native/splash-screen';

import { APIService } from '../services/api_service';
import { CartService } from '../services/cart_service';
import { PushService } from '../services/push_service';
import { UtilService } from '../services/util_service';
import { OrderHistoryService } from '../services/order_history_service';

import { TranslateLoader, TranslateModule } from '@ngx-translate/core';
import { TranslateHttpLoader } from '@ngx-translate/http-loader';
import { RestaurantsPageModule } from '../pages/catalog/restaurants/restaurants.module';
import { GeoPageModule } from '../pages/geo/geo.module';

@Injectable()
export class MyErrorHandler implements ErrorHandler {
  ionicErrorHandler: IonicErrorHandler;

  constructor(injector: Injector) {
    try {
      this.ionicErrorHandler = injector.get(IonicErrorHandler);
    } catch (e) {
    }
  }

  handleError(err: any): void {
    this.ionicErrorHandler && this.ionicErrorHandler.handleError(err);
  }
}

export function createTranslateLoader(http: HttpClient) {
  return new TranslateHttpLoader(http, './assets/i18n/', '.json');
}

@NgModule({
  declarations: [
    MyApp,
    TabsPage,
    Welcome,
    Loading,
    
  ],
  imports: [
    IonicModule.forRoot(MyApp, {
      scrollPadding: false,
      scrollAssist: true,
      autoFocusAssist: false
    }),
    IonicStorageModule.forRoot(),
    TranslateModule.forRoot({
      loader: {
        provide: TranslateLoader,
        useFactory: (createTranslateLoader),
        deps: [HttpClient]
      }
    }),
    BrowserModule,
    HttpModule,
    HttpClientModule,
    RestaurantsPageModule,
    GeoPageModule
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    TabsPage,
    Welcome,
    Loading,
    GeoPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    APIService,
    CartService,
    PushService,
    UtilService,
    OrderHistoryService,
    Geolocation,
    NativeGeocoder,
    // Comment these lines to disable ionic monitoring
    // IonicErrorHandler,
    // {provide: ErrorHandler, useClass: MyErrorHandler}
    // Uncomment this line to disable ionic monitoring
    {provide: ErrorHandler, useClass: IonicErrorHandler}
  ]
})
export class AppModule {
}
