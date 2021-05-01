//
//  ListingInfoVC.swift
//  UniBid
//
//  Created by Mario Yordanov on 1.05.21.
//

import UIKit

class ListingInfoVC: UIViewController, UICollectionViewDataSource, UICollectionViewDelegate {
    
    
    
    private var collectionView: UICollectionView!
    private let identifier: String = "identifier"
    private var images: [UIImage] = []

    override func viewDidLoad() {
        super.viewDidLoad()
        
        navigationBar.topItem?.title = "aaa"
        //navigationBar.topItem?.backBarButtonItem = UIBarButtonItem(title: "Back", style: .plain, target: self, action: "toBrowseViewController")
        let backButton = UIBarButtonItem()
         backButton.title = "New Back Button Text"
         self.navigationController?.navigationBar.topItem?.backBarButtonItem = backButton

        // Do any additional setup after loading the view.
        
        let flowLayout: UICollectionViewFlowLayout = UICollectionViewFlowLayout()
        flowLayout.minimumLineSpacing = 10
        flowLayout.scrollDirection = .horizontal
        flowLayout.minimumInteritemSpacing = 10
        flowLayout.sectionInset = UIEdgeInsets(top: 10, left: 10, bottom: 10, right: 10)
        flowLayout.itemSize = CGSize(width: 300, height: 300)
 
        
        collectionView = UICollectionView(frame: CGRect(x: 0, y: 110, width: view.frame.size.width, height: 115), collectionViewLayout: flowLayout)
                collectionView.dataSource = self
                collectionView.delegate = self
                collectionView.backgroundColor = UIColor.clear.withAlphaComponent(0)
                collectionView.alwaysBounceHorizontal = true
                collectionView.register(ImageCell.self, forCellWithReuseIdentifier: identifier)
                view.addSubview(collectionView)
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
    
    @IBAction func backBtn(_ sender: Any) {
        let vc = self.storyboard?.instantiateViewController(identifier: "BrowseViewController") as! BrowseViewController
        vc.modalPresentationStyle = .fullScreen
        self.present(vc, animated: true, completion: nil)
    }
    /*
    @IBAction func backButton(_ sender: Any) {
        let vc = self.storyboard?.instantiateViewController(identifier: "mainVC") as! MainViewController
        vc.modalPresentationStyle = .fullScreen
        self.present(vc, animated: true, completion: nil)
    }
     */
    
    
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        if(images.count > 5){
            return 5
        }
        return images.count
    }
     
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        let data: UIImage = images[indexPath.item]
        let cell: ImageCell = collectionView.dequeueReusableCell(withReuseIdentifier: identifier, for: indexPath) as! ImageCell
        cell.image.image = data
        return cell
    }
 
 

 
class ImageCell: UICollectionViewCell {
    var image: UIImageView!
 
    override init(frame: CGRect) {
        super.init(frame: frame)
        setupViews()
    }
     
    required init?(coder: NSCoder) {
        super.init(coder: coder)
        setupViews()
    }
     
    private func setupViews() {
        image = UIImageView(frame: CGRect(x: 0, y: 0, width: 300, height: 300))
        image.clipsToBounds = true
        image.contentMode = .scaleAspectFill
        addSubview(image)
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
