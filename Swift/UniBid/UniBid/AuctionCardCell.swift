//
//  AuctionCardCell.swift
//  UniBid
//
//  Created by Nikolay Stoyanov on 29.04.21.
//

import UIKit

class AuctionCardCell: UICollectionViewCell {
    
    @IBOutlet weak var imageView: UIImageView!
    
    @IBOutlet weak var auctionName: UILabel!
    func setAuctionCard(NameOfAuction:String,imageURL:String){
        setImage(from: "https://student.csc.liv.ac.uk/~sglbowma/\(imageURL)/image0.png")
        auctionName.text = NameOfAuction
    }
    // Method that sets image view
    func setImage(from url: String) {
        // get url for the image
        guard let imageURL = URL(string: url) else { return }

            // just not to cause a deadlock in UI!
        DispatchQueue.global().async {
            guard let imageData = try? Data(contentsOf: imageURL) else { return }

            let image = UIImage(data: imageData)
            DispatchQueue.main.async {
                self.imageView.image = image
            }
        }
    }
}
