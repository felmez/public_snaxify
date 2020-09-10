import { Component } from '@angular/core';
import { IonicPage, NavParams } from 'ionic-angular';

/**
 * Make an order page component
 */
@IonicPage()
@Component({
  selector: 'completed',
  templateUrl: 'completed.html'
})
export class CompletedPage {
  order;

  constructor(private navParams: NavParams) {
    this.order = this.navParams.get('order');
  }

}
