
import UIKit

class BrowseViewController: UIViewController,UICollectionViewDelegate,UICollectionViewDataSource,UICollectionViewDelegateFlowLayout{
    
    @IBOutlet weak var collectionView: UICollectionView!
    
    var listings: [[String:String?]]?
    var selectedListing: [String:String?] = [:]
    var listingCount: Int = 0
    override func viewDidLoad() {
        // Do any additional setup after loading the view.
        
        loadListing()
        
        super.viewDidLoad()
    }
    override func viewDidAppear(_ animated: Bool) {
            super.viewDidAppear(animated)
        collectionView.register(AuctionCardCell.self, forCellWithReuseIdentifier: "AuctionCard")
        collectionView.delegate = self
        collectionView.dataSource = self
        }
    
    func loadListing(){
        let URLSesh = "https://student.csc.liv.ac.uk/~sglbowma/api/appApi.php"
        guard let url = URL(string: URLSesh) else {return}
        
        URLSession.shared.dataTask(with: url) { data, response, err in
            guard let jsonData = data else {return}
            
            do{
                typealias Listings = [[String:String?]]
                self.listings = try? JSONDecoder().decode(Listings.self, from: jsonData)
                for i in 0..<(self.listings!.count-1){
                    
                        self.listingCount = self.listingCount + 1
                    
                    
                    for (key,value) in self.listings![i]{
                   // print("key=\(key), value=\(String(describing: value))")
                       // print(type(of: self.listings))
                }
                }
                
            }
        }.resume()
    }
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        return self.listingCount
    }

    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        guard let cell = collectionView.dequeueReusableCell(withReuseIdentifier: "AuctionCard", for: indexPath) as? AuctionCardCell else {
            // we failed to get a PersonCell – bail out!
            fatalError("Unable to dequeue AuctionCell.")
        }
        let val = listings![indexPath.row]["listing_name"]
        let val2 = listings![indexPath.row]["images"]

        cell.setAuctionCard( NameOfAuction: val!!,imageURL: val2!!)

        // if we're still here it means we got a PersonCell, so we can return it
        return cell
    }
    func collectionView(_ collectionView: UICollectionView, didSelectItemAt indexPath: IndexPath) {
        selectedListing = listings![indexPath.item]
        performSegue(withIdentifier: "toAuctionView", sender: nil)
    }
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, sizeForItemAt indexPath: IndexPath) -> CGSize {
        return CGSize(width: view.frame.size.width/3, height: view.frame.size.height/6)
    }
    
    func collectionView(_ collectionView: UICollectionView, layout collectionViewLayout: UICollectionViewLayout, insetForSectionAt section: Int) -> UIEdgeInsets {
        return UIEdgeInsets(top: 10, left: 20, bottom: 10, right: 20)
    }
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        if (segue.identifier == "toAuctionView"){
                let vc = segue.destination as! ListingInfoVC
                vc.selectedListing = self.selectedListing
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
