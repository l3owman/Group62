//
//  AuctionCardCell.swift
//  UniBid
//
//  Created by Nikolay Stoyanov on 29.04.21.
//

import UIKit

class AuctionCardCell: UICollectionViewCell {
    
    var imageView: UIImageView?
    var label: UILabel?



    override init(frame: CGRect) {
        super.init(frame: frame)

        imageView = UIImageView(frame: self.bounds)
        imageView?.contentMode = .scaleAspectFit
        //customise imageview
        imageView?.backgroundColor = UIColor.clear
        imageView?.image = #imageLiteral(resourceName: "image_2")
        contentView.addSubview(imageView!)
        label = UILabel(frame: CGRect(x: 40, y: 140, width: self.bounds.width - 20, height: 20))
        //Customsize label
        label?.text = "Hello"
        label?.textColor = UIColor.red
        contentView.addSubview(label!)
    }

    required init?(coder aDecoder: NSCoder) {
        fatalError("init(coder:) has not been implemented")
    }

    override var bounds: CGRect {
        didSet {
            contentView.frame = bounds
        }
    }
    override func prepareForReuse() {
        super.prepareForReuse()
    }
    func setAuctionCard(NameOfAuction:String,imageURL:String){
        if(verifyUrl(urlString: "https://student.csc.liv.ac.uk/~sgcdeega/\(imageURL)/image0.png"))
        {
            setImage(from: "https://student.csc.liv.ac.uk/~sgcdeega/\(imageURL)/image0.png")
        }
        if(verifyUrl(urlString: "https://student.csc.liv.ac.uk/~sgcdeega/\(imageURL)/image0.jpg"))
        {
            setImage(from: "https://student.csc.liv.ac.uk/~sgcdeega/\(imageURL)/image0.jpg")
        }
        if(verifyUrl(urlString: "https://student.csc.liv.ac.uk/~sgcdeega/\(imageURL)/image0.jpeg"))
        {
            setImage(from: "https://student.csc.liv.ac.uk/~sgcdeega/\(imageURL)/image0.jpeg")
        }
        label?.text = NameOfAuction
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
                self.imageView!.image = image
            }
        }
    }
    
    
    func verifyUrl(urlString: String?) -> Bool {
        if let urlString = urlString {
            if let url = URL(string: urlString) {
                return UIApplication.shared.canOpenURL(url)
            }
        }
        return false
    }
}
