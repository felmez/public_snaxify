import { Component } from '@angular/core';
import { APIService } from '../../../services/api_service';
import { IonicPage, NavController, NavParams } from 'ionic-angular';
import { FirebaseAuthentication } from '@ionic-native/firebase-authentication/ngx';

/**
 * Categories list page component
 */
@IonicPage()
@Component({
  selector: 'home',
  templateUrl: 'home.html'
})
export class HomePage {
  public categories;
  public sectionId;
  public restaurantId;
  public loggedIn = false;
  public news;

  public videoUrl;
  private videos = [
    // TODO:
    // 'assets/video/kitchen1.mp4',
    // 'assets/video/kitchen2.mp4',
    // 'assets/video/kitchen3.mp4',
  ];


  private categoryIcons = [
    'assets/icon/categories/food-0.svg',
    'assets/icon/categories/food-1.svg',
    'assets/icon/categories/food-2.svg',
    'assets/icon/categories/food-3.svg',
    'assets/icon/categories/food-4.svg',
    'assets/icon/categories/food-5.svg',
    'assets/icon/categories/food-6.svg',
    'assets/icon/categories/food-7.svg',
    'assets/icon/categories/food-8.svg',
    'assets/icon/categories/food-9.svg',
    'assets/icon/categories/food-10.svg',
    'assets/icon/categories/food-11.svg',
  ];
  private categoryFlatIcons = [
    'assets/icon/categories-flat/food-0.svg',
    'assets/icon/categories-flat/food-1.svg',
    'assets/icon/categories-flat/food-2.svg',
    'assets/icon/categories-flat/food-3.svg',
    'assets/icon/categories-flat/food-4.svg',
  ];
  

  constructor(
    private nav: NavController,
    private apiService: APIService,
    private params: NavParams
  ) {
    this.categories = this.getCategories();
    this.sectionId = params.get('id');
    this.restaurantId = params.get('restaurant_id');
    this.loggedIn = this.apiService.isLoggedIn();


    this.videoUrl = this.videos[Math.round(Math.random() * (1 - 0) + 0)];
  }

  /* Temp, Example Func */
  getRandomCategoryIcon(max) {
    return this.categoryIcons[Math.round(Math.random() * (11 - 0) + 0)];
  }

  ionViewWillEnter() {
    this.apiService.reloadCategories(this.restaurantId).then(() => {
      this.categories = this.getCategories();
    });
  }

  getCategories() {
    let result = [];
    this.apiService.getCategories().forEach((c) => {
      if (c.parent_id == this.sectionId) {
        result.push(c);
      }
    });
    return result;
  }

  showDetails(category) {
    
      this.nav.push('RestaurantsPage');
    
  }

  showNews(item) {
    this.nav.push('NewsDetailPage', {item: item});
  }

}
