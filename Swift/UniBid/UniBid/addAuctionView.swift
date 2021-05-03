//
//  addAuctionView.swift
//  UniBid
//
//  Created by Mario Yordanov on 22.04.21.
//

import UIKit
import Photos
import BSImagePicker


class addAuctionView: UIViewController, UITextFieldDelegate, UITextViewDelegate, UIPickerViewDelegate, UIPickerViewDataSource, UICollectionViewDelegate, UICollectionViewDataSource {
    
    
    private var collectionView: UICollectionView!
    private let identifier: String = "identifier"
    private var selectedImages: [UIImage] = []
    

    override func viewDidLoad() {
        super.viewDidLoad()

        // Do any additional setup after loading the view.
        listingTitle.delegate = self
        listingDescription.delegate = self
        pickerViewCategory.delegate = self
        pickerViewCategory.dataSource = self
        listingCategory.inputView = pickerViewCategory
        listingBidPrice.delegate = self
        listingBuyNowPrice.delegate = self
        pickerViewDuration.delegate = self
        pickerViewDuration.dataSource = self
        listingDuration.inputView = pickerViewDuration
        
        
        let tap = UITapGestureRecognizer(target: self, action: #selector(handleTap))
        view.addGestureRecognizer(tap) // Add gesture recognizer to background view
        
        
        let btnSelectImage: UIButton = UIButton(frame: CGRect(x: 30, y: 606, width: view.frame.size.width - 60, height: 30))
               btnSelectImage.setTitle("Select images", for: .normal)
               btnSelectImage.setTitleColor(UIColor.systemBlue, for: .normal)
               btnSelectImage.contentHorizontalAlignment = .left
               btnSelectImage.addTarget(self, action: #selector(selectImages), for: .touchUpInside)
               view.addSubview(btnSelectImage)
        
        let flowLayout: UICollectionViewFlowLayout = UICollectionViewFlowLayout()
        flowLayout.minimumLineSpacing = 10
        flowLayout.scrollDirection = .horizontal
        flowLayout.minimumInteritemSpacing = 10
        flowLayout.sectionInset = UIEdgeInsets(top: 10, left: 10, bottom: 10, right: 10)
        flowLayout.itemSize = CGSize(width: 300, height: 300)
 
        
        collectionView = UICollectionView(frame: CGRect(x: 0, y: btnSelectImage.frame.origin.y + btnSelectImage.frame.size.height + 10, width: view.frame.size.width, height: 115), collectionViewLayout: flowLayout)
                collectionView.dataSource = self
                collectionView.delegate = self
                collectionView.backgroundColor = UIColor.clear.withAlphaComponent(0)
                collectionView.alwaysBounceHorizontal = true
                collectionView.register(ImageCell.self, forCellWithReuseIdentifier: identifier)
                view.addSubview(collectionView)
        
    }
    
    let categories = ["Kitchen","Bedroom","Outdoors","Bathroom","Books & Stationery","Miscellaneous"]
    let durations = ["Quick - 5 Hours","Short - 24 Hours","Medium - 3 Days","Long - 7 Days"]
    
    var pickerViewCategory = UIPickerView()
    var pickerViewDuration = UIPickerView()
    
    //UI elements
    @IBOutlet weak var listingTitle: UITextField!
    @IBOutlet weak var listingDescription: UITextView!
    @IBOutlet weak var listingCategory: UITextField!
    @IBOutlet weak var listingBidPrice: UITextField!
    @IBOutlet weak var listingBuyNowPrice: UITextField!
    @IBOutlet weak var listingDuration: UITextField!
    @IBOutlet weak var charactersLeft: UILabel!
    
    @IBAction func createListingBtn(_ sender: Any) {
        let title = String(listingTitle.text!)
        let description =  String(listingDescription.text!)
        let category = String(listingTitle.text!)
        let bidPrice = String(listingBidPrice.text!)
        let duration = String(listingDuration.text!)
        var alertMessageTitle = ""
        var alertMessage = ""
        
        if(title == "") {
            alertMessageTitle = "Title is a mandatory field"
            alertMessage = "Please input a title for your listing."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(description == "") {
            alertMessageTitle = "Description is a mandatory field"
            alertMessage = "Please input a description for your listing."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(category == "") {
            alertMessageTitle = "Category is a mandatory field"
            alertMessage = "Please select a category for your listing."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(bidPrice == "") {
            alertMessageTitle = "Bid Price is a mandatory field"
            alertMessage = "Please input a bid price for your listing."
            showAlert(alertMessageTitle, alertMessage)
        }
        else if(duration == "") {
            alertMessageTitle = "Duration is a mandatory field"
            alertMessage = "Please select a duration for your listing."
            showAlert(alertMessageTitle, alertMessage)
        }
        else {
            alertMessageTitle = "Listing Created"
            alertMessage = "Congratulations you have successfully created a listing."
            showAlert(alertMessageTitle, alertMessage)
        }
    }
    
    // Objects
    @objc func handleTap() {
        listingTitle.resignFirstResponder() // dismiss keyboard
        listingDescription.resignFirstResponder()
        listingBidPrice.resignFirstResponder()
        listingBuyNowPrice.resignFirstResponder()
    }
    
    
    // UITextFieldDelegete Methods
    func textFieldShouldReturn(_ textField: UITextField) -> Bool {
        listingTitle.resignFirstResponder() // dismiss keyboard
        listingDescription.resignFirstResponder()
        
        listingBidPrice.resignFirstResponder()
        listingBuyNowPrice.resignFirstResponder()
        
        
        return true
    }
    
    func textField(_ textField: UITextField, shouldChangeCharactersIn range: NSRange, replacementString string: String) -> Bool {
        if textField == listingTitle { // make sure the listing title is under 150 characters
            // get the current text, or use an empty string if that failed
            let currentText = textField.text ?? ""

            // attempt to read the range they are trying to change, or exit if we can't
            guard let stringRange = Range(range, in: currentText) else { return false }

            // add their new text to the existing text
            let updatedText = currentText.replacingCharacters(in: stringRange, with: string)

            // make sure the listing title is under 150 characters
            return updatedText.count <= 25
        } else if textField == listingBidPrice || textField == listingBuyNowPrice { // make sure we have only two digits after the . for the prices
            guard let oldText = textField.text, let r = Range(range, in: oldText) else {
                    return true
                }

                let newText = oldText.replacingCharacters(in: r, with: string)
                let isNumeric = newText.isEmpty || (Double(newText) != nil)
                let numberOfDots = newText.components(separatedBy: ".").count - 1

                let numberOfDecimalDigits: Int
            if let dotIndex = newText.firstIndex(of: ".") {
                    numberOfDecimalDigits = newText.distance(from: dotIndex, to: newText.endIndex) - 1
                } else {
                    numberOfDecimalDigits = 0
                }

                return isNumeric && numberOfDots <= 1 && numberOfDecimalDigits <= 2
            
        } else {
            return true
        }
    }
    
    // UIPickerView Methods
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        if pickerView == pickerViewCategory {
            //print(1)
            return categories.count
        } else {
            //print(3)
            return durations.count
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        if pickerView == pickerViewCategory {
            return categories[row]
        } else {
            return durations[row]
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        if pickerView == pickerViewCategory {
            listingCategory.text = categories[row]
            listingCategory.resignFirstResponder()
        } else {
            listingDuration.text = durations[row]
            listingDuration.resignFirstResponder()
        }
    }

    // UITextView Methods
    func textView(_ textView: UITextView, shouldChangeTextIn range: NSRange, replacementText text: String) -> Bool {
        if textView == listingDescription {
            // get the current text, or use an empty string if that failed
            let currentText = textView.text ?? ""

            // attempt to read the range they are trying to change, or exit if we can't
            guard let stringRange = Range(range, in: currentText) else { return false }

            // add their new text to the existing text
            let updatedText = currentText.replacingCharacters(in: stringRange, with: text)

            // make sure the description of a listing is under 1000 characters
            return updatedText.count <= 300
        } else {
            return true
        }
    }
    
    func textViewDidChange(_ textView: UITextView) {
        charactersLeft.text = "\(textView.text.count)/300"
    }
    
    @objc private func selectImages(sender: UITapGestureRecognizer) {
        let imagePicker = ImagePickerController()
        //imagePicker.settings.fetch.assets.supportedMediaTypes = [.image(max: 2), .video(max: 1)]
        presentImagePicker(imagePicker, select: { (asset) in
        }, deselect: { (asset) in
             
        }, cancel: { (assets) in
             
        }, finish: { (assets) in
             
            self.selectedImages = []
            let options: PHImageRequestOptions = PHImageRequestOptions()
            options.deliveryMode = .highQualityFormat
 
            for asset in assets {
                PHImageManager.default().requestImage(for: asset, targetSize: PHImageManagerMaximumSize, contentMode: .aspectFit, options: options) { (image, info) in
                    self.selectedImages.append(image!)
                    self.collectionView.reloadData()
                }
            }
        })
    }
     
    func collectionView(_ collectionView: UICollectionView, numberOfItemsInSection section: Int) -> Int {
        if(selectedImages.count > 5){
            return 5
        }
        return selectedImages.count
    }
     
    func collectionView(_ collectionView: UICollectionView, cellForItemAt indexPath: IndexPath) -> UICollectionViewCell {
        let data: UIImage = selectedImages[indexPath.item]
        let cell: ImageCell = collectionView.dequeueReusableCell(withReuseIdentifier: identifier, for: indexPath) as! ImageCell
        cell.image.image = data
        return cell
    }
    
    
    func showAlert(_ messageTitle: String, _ message: String) {
        DispatchQueue.main.async {
            //Create an alert
            let alert = UIAlertController(title: messageTitle, message: message, preferredStyle: .alert)
            //Add actions
            if(messageTitle == "Listing Created"){
                let alertAction = UIAlertAction(title: "My Listings", style: .cancel, handler: {(action) -> Void in
                    //Call the MainViewController
                    let vc = self.storyboard?.instantiateViewController(identifier: "MyListingsViewController") as! MyListingsViewController
                    vc.modalPresentationStyle = .fullScreen
                    self.present(vc, animated: true, completion: nil)
                })
                
                alert.addAction(alertAction)
            } else {
                alert.addAction(UIAlertAction(title: "OK", style: .default, handler: nil))
            }

            //Present alert
            self.present(alert, animated: true, completion: nil)
        }
    }
 
 
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

    
    
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
