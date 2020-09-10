import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { OrdersHistoryPage } from './orders_history';
import { TranslateModule } from '@ngx-translate/core';
import { PipesModule } from '../../../pipes/pipes.module';

@NgModule({
  declarations: [
    OrdersHistoryPage
  ],
  imports: [
    PipesModule,
    IonicPageModule.forChild(OrdersHistoryPage),
    TranslateModule.forChild()
  ]
})
export class OrdersHistoryPageModule {
}
