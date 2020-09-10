import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { OrderViewPage } from './order_view';
import { TranslateModule } from '@ngx-translate/core';
import { PipesModule } from '../../../pipes/pipes.module';

@NgModule({
  declarations: [
    OrderViewPage
  ],
  imports: [
    PipesModule,
    IonicPageModule.forChild(OrderViewPage),
    TranslateModule.forChild()
  ]
})
export class OrdersHistoryPageModule {
}
