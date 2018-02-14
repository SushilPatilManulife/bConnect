//
//  AppDelegate.swift
//  BeaconDemo2
//
//  Created by Ron Buencamino on 9/19/16.
//  Copyright © 2016 Animatronic Gopher Inc. All rights reserved.
//

import UIKit
import UserNotifications
import CoreLocation


let COLOR_MAIN_PRIMARY_RED = UIColor(red: 149.0/255, green: 0.0/255, blue: 44.0/255, alpha: 1.0)
let NOTIFICATION_REMINDER_KEY = "is_reminde"
let storedOffersKey = "storedOffers"
let onlineStoredOffersKey = "online_store_Offers"

let CATEGORY_ANNOUNCEMENT_KEY = "Announcement"
let CATEGORY_EVENT_KEY = "ArtExhibition"
let CATEGORY_LIBRARY_KEY = "NewBook"
let CATEGORY_APPARTMENT_KEY = "Apartment"
let CATEGORY_RESTAURANT_KEY = "Restaurant"





var navigationController : UINavigationController!
@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate, UNUserNotificationCenterDelegate {

    var window: UIWindow?
    
    func application(_ application: UIApplication, didFinishLaunchingWithOptions launchOptions: [UIApplicationLaunchOptionsKey: Any]?) -> Bool {
        // Override point for customization after application launch.
        
        let navController = UINavigationController(rootViewController: HomeViewController(nibName: "HomeViewController", bundle: nil))
        navController.navigationBar.isTranslucent = false
        navController.navigationBar.barTintColor = COLOR_MAIN_PRIMARY_RED
        navController.navigationBar.tintColor = UIColor.white
        navController.navigationBar.titleTextAttributes = [NSForegroundColorAttributeName: UIColor.white]
        self.window?.rootViewController = navController
        UserDefaults.standard.removeObject(forKey: onlineStoredOffersKey)
       self.allDefaultsSave()
        
       
        UIApplication.shared.applicationIconBadgeNumber = 0
        
        UNUserNotificationCenter.current().requestAuthorization(options: [.sound,.badge,.alert]) { (success, error) in
            if success {
                print("Accepting notifications")
                UNUserNotificationCenter.current().delegate = self
                DispatchQueue.main.async {
                     BeaconManager.sharedInstance.delegate = self
                    BeaconManager.sharedInstance.setupForDiscovery()
                     // BeaconManager.sharedInstance.dummyNotification(isEnter: true , num : 3)
                   
                }
                
            } else {
                print("Receive notifications declined")
            }
        }
        
        
       // BeaconManager.sharedInstance.dummyNotification(isEnter: true , num : 1)
      //  BeaconManager.sharedInstance.dummyNotification(isEnter: true , num : 0)
        return true
    }
    func allDefaultsSave() -> Void {
        
        if UserDefaults.standard.value(forKey: onlineStoredOffersKey) == nil {
            let arr : [[String : AnyObject]] = []
            UserDefaults.standard.setValue(arr, forKey: onlineStoredOffersKey)
        }
        if UserDefaults.standard.value(forKey: "setting") == nil {
            let s = Setting()
            s.saveSetting()
        }
        let array : [String : [[String : AnyObject]]] = [String : [[String : AnyObject]]]()
        if UserDefaults.standard.value(forKey: CATEGORY_EVENT_KEY) == nil {
            UserDefaults.standard.setValue(array, forKey: CATEGORY_EVENT_KEY)
        }
        if UserDefaults.standard.value(forKey: CATEGORY_LIBRARY_KEY) == nil {
            UserDefaults.standard.setValue(array, forKey: CATEGORY_LIBRARY_KEY)
        }
        if UserDefaults.standard.value(forKey: CATEGORY_APPARTMENT_KEY) == nil {
            UserDefaults.standard.setValue(array, forKey: CATEGORY_APPARTMENT_KEY)
        }
        if UserDefaults.standard.value(forKey: CATEGORY_RESTAURANT_KEY) == nil {
            UserDefaults.standard.setValue(array, forKey: CATEGORY_RESTAURANT_KEY)
        }
        if UserDefaults.standard.value(forKey: CATEGORY_ANNOUNCEMENT_KEY) == nil {
            UserDefaults.standard.setValue(array, forKey: CATEGORY_ANNOUNCEMENT_KEY)
        }
        
    }
    func userNotificationCenter(_ center: UNUserNotificationCenter, didReceive response: UNNotificationResponse, withCompletionHandler completionHandler: @escaping () -> Void) {
        
        let userInfo = response.notification.request.content.userInfo
        let id = (userInfo["identifier"] as! String)
        let majr = (userInfo["major"] as! Int)
        let minor = (userInfo["minor"] as! Int)
        let isEntry = (userInfo["isEntry"] as! Bool)
       
        for of in self.getAllOffers() {
            if of.uuid.uuidString.lowercased() == id.lowercased() && Int(of.majorValue) == majr && Int(of.minorValue) == minor{
                of.isEntryOffer = isEntry
                self.navigateToOfferController(off: of)
                break
            }
        }
        
//        self.navigateToOfferController(off: Offer(id: 1, name: "demo", desc: "sfnkjsndgflnsdndslnvlsdn", icon: 1, uuid: UUID(uuidString: "c1c8f968-f4a8-46a2-9515-7ce75b8f2079")!, majorValue: 1, minorValue: 1, isEntry: true))
//        
//        
//        NotificationCenter.default.post(name: NSNotification.Name.init(rawValue: "NotificationFired"), object: nil, userInfo: userInfo)
        
        completionHandler()
    }
    func navigateToOfferController(off : Offer) -> Void {
        
        self.saveHistoryOffer(of: off)
        
         let navController = UINavigationController(rootViewController: HomeViewController(nibName: "HomeViewController", bundle: nil))
        navController.navigationBar.isTranslucent = false
        navController.navigationBar.barTintColor = COLOR_MAIN_PRIMARY_RED
        navController.navigationBar.tintColor = UIColor.white
        navController.navigationBar.titleTextAttributes = [NSForegroundColorAttributeName: UIColor.white]
        var arr = navController.viewControllers
        if off.category == CATEGORY_RESTAURANT_KEY {
            let storyboard = UIStoryboard(name: "MainInterface", bundle: Bundle.main)
            let dialView:TodayViewController = storyboard.instantiateViewController(withIdentifier: "TodayViewController") as! TodayViewController
            arr.append(dialView)
            
        }else {
            let hc = HistoryViewController(nibName: "HistoryViewController", bundle: nil)
            hc.category = off.category
            arr.append(hc)
        }
        
        
       let vc = self.getController(of: off)
        //vc.offer = of
        
        arr.append(vc)
        navController.viewControllers = arr
        self.window?.rootViewController = navController
        
        
    }
    
    func getController(of : Offer) -> UIViewController {
        var vc : UIViewController!
        switch of.category {
        case CATEGORY_EVENT_KEY:
            let vc1 : OfferDetailsViewController = OfferDetailsViewController(nibName: "OfferDetailsViewController", bundle: nil) 
            vc1.offer = of
            vc = vc1
        case CATEGORY_ANNOUNCEMENT_KEY:
            let vc1 : AnnouncementViewController = AnnouncementViewController(nibName: "AnnouncementViewController", bundle: nil)
            vc1.offer = of
            vc = vc1
        case CATEGORY_LIBRARY_KEY:
            let vc1 : LibraryViewController = LibraryViewController(nibName: "LibraryViewController", bundle: nil)
            vc1.offer = of
            vc = vc1
        case CATEGORY_APPARTMENT_KEY:
            let vc1 : ApartmentViewController = ApartmentViewController(nibName: "ApartmentViewController", bundle: nil)
            vc1.offer = of
            vc = vc1
        case CATEGORY_RESTAURANT_KEY:
            let vc1 : RestaurantViewController = RestaurantViewController(nibName: "RestaurantViewController", bundle: nil)
            vc1.offer = of
            vc = vc1
        default:
             let vc1 : OfferDetailsViewController = OfferDetailsViewController(nibName: "OfferDetailsViewController", bundle: nil)
             vc1.offer = of
             vc = vc1
        }
        
        if vc == nil {
            let vc1 : OfferDetailsViewController = OfferDetailsViewController(nibName: "OfferDetailsViewController", bundle: nil)
            vc1.offer = of
            vc = vc1
        }
        return vc
    }
    
    func saveHistoryOffer(of : Offer) -> Void {
        WebServiceManager.sharedInstance.saveHistoryForkey(category: of.category, offer: of, date: Date().toString(), info: nil)
    }
    
    func userNotificationCenter(_ center: UNUserNotificationCenter, willPresent notification: UNNotification, withCompletionHandler completionHandler: @escaping (UNNotificationPresentationOptions) -> Void) {
        
        completionHandler([.alert,.badge,.sound])
    }

    func applicationWillResignActive(_ application: UIApplication) {
        // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
        // Use this method to pause ongoing tasks, disable timers, and invalidate graphics rendering callbacks. Games should use this method to pause the game.
    }

    func applicationDidEnterBackground(_ application: UIApplication) {
        // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later.
        // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
    }

    func applicationWillEnterForeground(_ application: UIApplication) {
        // Called as part of the transition from the background to the active state; here you can undo many of the changes made on entering the background.
    }

    func applicationDidBecomeActive(_ application: UIApplication) {
        // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    }

    func applicationWillTerminate(_ application: UIApplication) {
        // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
    }
    func getAllOffers() -> [Offer] {
       /* var array : [Offer] = []
        
        guard let storedItems = UserDefaults.standard.array(forKey: storedOffersKey) as? [Data] else { return array}
        for itemData in storedItems {
            guard let item = NSKeyedUnarchiver.unarchiveObject(with: itemData) as? Offer else { continue }
            array.append(item)
            
        }*/
        return WebServiceManager.sharedInstance.getofferFromOffline()
        
    }



}

// MARK: CLLocationManagerDelegate
extension AppDelegate: BeaconManagerDelegate {
    func beaconManager(_ manager: CLLocationManager, monitoringDidFailFor region: CLRegion?, withError error: Error) {
        print("Failed monitoring region: \(error.localizedDescription)")
    }
    
    func beaconManager(_ manager: CLLocationManager, didFailWithError error: Error) {
        print("Failed monitoring region: \(error.localizedDescription)")
    }
    
    func beaconManager(_ manager: CLLocationManager, didRangeBeacons beacons: [CLBeacon], in region: CLBeaconRegion) {
        
      /*  // Find the same beacons in the table.
        var indexPaths = [IndexPath]()
        for beacon in beacons {
            for row in 0..<offers.count {
                if offers[row].is_equal(beacon: region) {
                    offers[row].beacon = beacon
                    indexPaths += [IndexPath(row: row, section: 0)]
                }
            }
        }
        
        // Update beacon locations of visible rows.
        if let visibleRows = tableView.indexPathsForVisibleRows {
            let rowsToUpdate = visibleRows.filter { indexPaths.contains($0) }
            for row in rowsToUpdate {
                let cell = tableView.cellForRow(at: row) as! ItemCell
                cell.refreshLocation()
            }
        }
 */
        
    }
    
    func beaconManager(_ manager: CLLocationManager, didEnterRegion region: CLRegion) {
        print("enter in beacons")
        let beaconRegion = region as! CLBeaconRegion
        var offer : Offer!
        for of in self.getOffers() {
            /*if of.uuid == beaconRegion.proximityUUID && of.isEntryOffer{
             offer = of
             break
             }*/
            
            if of.is_equal(beacon: beaconRegion){
                offer = of
                offer.isEntryOffer = true
                break
            }
        }
        if offer == nil {
            print("offer not avaliable")
            return
        }
        let state = UIApplication.shared.applicationState
        
        if state == .background && offer != nil{
            
            BeaconManager.sharedInstance.handalOfferNotification(offer: offer)
            // delegate?.scheduleNotification(at: Date(), userInfo: offer.getDetails())
            
        }else {
            self.showAlert(message: offer.entry_descriptions.capitalized)
        }
    }
    func beaconManager(_ manager: CLLocationManager, didExitRegion region: CLRegion) {
        print("enter in exit")
        let beaconRegion = region as! CLBeaconRegion
        var offer : Offer!
        for of in self.getOffers() {
            /*if of.uuid == beaconRegion.proximityUUID && !of.isEntryOffer{
             offer = of
             break
             }*/
            
            if of.is_equal(beacon: beaconRegion){
                offer = of
                offer.isEntryOffer = false
                break
            }
        }
        
        
        if offer == nil {
            print("offer not avaliable")
            return
        }
        
        
        let state = UIApplication.shared.applicationState
        
        if state == .background && offer != nil{
            let delegate = UIApplication.shared.delegate as? AppDelegate
            //delegate?.scheduleNotification(at: Date(), userInfo: offer.getDetails())
            BeaconManager.sharedInstance.handalOfferNotification(offer: offer)
            
            
        }else {
            self.showAlert(message: offer.exit_descriptions.capitalized)
        }
        
        
    }
    
    func showAlert(message : String) -> Void {
        let alert = UIAlertController(title: "Offer", message: message, preferredStyle: UIAlertControllerStyle.alert)
        alert.addAction(UIAlertAction(title: "Okay", style: UIAlertActionStyle.default, handler: nil))
        let nav = UIApplication.shared.windows[0].rootViewController as! UINavigationController
        let vc = nav.viewControllers[0]
        vc.present(alert, animated: true, completion: nil)
    }
    
    func getOffers() -> [Offer] {
        var array : [Offer] = []
        /*
         guard let storedoffers = UserDefaults.standard.array(forKey: storedOffersKey) as? [Data] else { return array }
         for itemData in storedoffers {
         guard let item = NSKeyedUnarchiver.unarchiveObject(with: itemData) as? Offer else { continue }
         array.append(item)
         
         }*/
        array = WebServiceManager.sharedInstance.getofferFromOffline()
        return array
    }
    
}
