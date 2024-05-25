export const isImage =(attachement)=>{
    let mime =  attachement.mime || attachement.type
      mime =mime.split('/')
    return mime[0].toLowerCase()==='image'
}