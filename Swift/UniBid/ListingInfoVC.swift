//
//  ListingInfoVC.swift
//  UniBid
//
//  Created by Mario Yordanov on 1.05.21.
//

import UIKit

class ListingInfoVC: UIViewController {
    
    
    var selectedListing: [String:String?] = [:]
    private var collectionView: UICollectionView!
    private let identifier: String = "identifier"


    override func viewDidLoad() {
        super.viewDidLoad()
        
        if let entryy = selectedListing["listing_name"] {
            navigationBar.topItem?.title = entryy
        }
        if let entryy = selectedListing["description"] {
            descriptionFIeld.text = "Listing description:\n" + entryy!
        }
        if let entryy = selectedListing["start_price"] {
            bidsStartLabel.text = "Bids start from: " + entryy! + "£"
        }
        if let entryy = selectedListing["buy_now_price"] {
            buyNowLabel.text = "Buy Now Price: " + entryy! + "£"
        }
        if let entryy = selectedListing["images"] {
            setImage(from: "https://student.csc.liv.ac.uk/~sgcdeega/" + entryy! + "/image0.png")
        }
        //navigationBar.topItem?.backBarButtonItem = UIBarButtonItem(title: "Back", style: .plain, target: self, action: "toBrowseViewController")
        let backButton = UIBarButtonItem()
         backButton.title = "New Back Button Text"
         self.navigationController?.navigationBar.topItem?.backBarButtonItem = backButton

        // Do any additional setup after loading the view.
        
    }
    
    @IBOutlet weak var descriptionFIeld: UITextView!
    @IBOutlet weak var bidsStartLabel: UILabel!
    @IBOutlet weak var placeBidField: UITextField!
    @IBAction func placeBidBtn(_ sender: Any) {
        
    }
    @IBOutlet weak var buyNowLabel: UILabel!
    @IBAction func buyNowBtn(_ sender: Any) {
    }
    @IBOutlet weak var navigationBar: UINavigationBar!
    
    @IBOutlet weak var imageView: UIImageView!
    
    
    @IBAction func backBtn(_ sender: Any) {
        let vc = self.storyboard?.instantiateViewController(identifier: "BrowseViewController") as! BrowseViewController
        vc.modalPresentationStyle = .fullScreen
        self.present(vc, animated: true, completion: nil)
    }
    
    func setImage(from url: String) {
        // get url for the image
        guard let imageURL = URL(string: url) else { return }

            // just not to cause a deadlock in UI!
        DispatchQueue.global().async {
            guard let imageData = try? Data(contentsOf: imageURL) else { return }

            let image = UIImage(data: imageData)
            DispatchQueue.main.async {
                self.imageView!.image = image
            }
        }
    }

    
    

    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
