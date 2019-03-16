import React,{Component} from "react";
import {
    arrayMove,
} from 'react-sortable-hoc';

//import sortableList from 'sortable/sortable';

import Ajax from './../module/ajax/index';
import Cropper from './gallery/cropper'
import ReactFileReader from 'react-file-reader';
//import Message from './gallery/message';
import Preloader from './gallery/preloader';
//import Form from './gallery/form';

export default class Base extends Component {

    constructor(props){
        super(props);
        let elem = document.getElementById('gallery');
        this.state = {
            //entity:document.getElementById('allComments').getAttribute('data-entity'),
            data:[],
            item:[],
            cropModal:false,

            id :     elem !=undefined ?   elem.getAttribute('data-id') : null,
            type :   elem !=undefined ?   elem.getAttribute('data-type') : null,
            max :    elem !=undefined && elem.getAttribute('data-mode')!="single" ?   elem.getAttribute('data-max') : 1,
            host :   elem !=undefined ?   elem.getAttribute('data-host') : null,
            aspectRatio : elem !=undefined ?   elem.getAttribute('data-aspect-ratio') : null,
            size:[],

            hideMessage:true,
            textMessage:'',
            files:[],



            items : [],
            preloader:false
        }

        //this.inputOpenFileRef = React.createRef()

    }

    render(){
        const data = this.state.files.length!=0 ? this.state.files : null;
        console.log(this.state.items);
        return (

            <div className="gallery">
                {!this.state.hideMessage ? <div className="message">{this.state.textMessage}</div> : null}
                {this.state.preloader ? <Preloader /> :

                    <div>

                        {this.state.cropModal ?
                            <div className="col-md-12">
                                <Cropper image={this.state.item} size={this.state.size} setData={this.setCropData} aspectRatio={this.state.aspectRatio}/>
                            </div> :null}

                        { this.state.data.length + this.state.items.length < this.state.max ?
                            <div>
                                <ReactFileReader fileTypes={[".png",".jpg"]} base64={true} id={"upload"} name={"Gallery[upload]"} multipleFiles={false} handleFiles={this.handleFiles}>
                                    {/*<button className='btn'>Upload</button>*/}
                                    <div className="custom-file">
                                        <label className="custom-file-label" htmlFor="upload">
                                            <span id="uploadText">Выбрать файл</span>
                                        </label>
                                    </div>
                                    <div className="input-group"></div>
                                </ReactFileReader>

                                <input id="myInput" type="file"
                                       multiple={true}
                                       ref={this.inputOpenFileRef}
                                       style={{display: 'none'}}
                                       onChange={this.uploadFile}
                                />
                            </div>:null}


                        {
                            this.state.data.length!=0 ?
                                this.state.data.map((item,i)=>
                                    <div className={"itemGallery"} key={i}>
                                        <input type={"hidden"} name={`storage[${i}]`} hidden={true} defaultValue={item.base64} />
                                        <div className={"image"}>
                                            <img src={item.base64} className={"image"}/>
                                            <i onClick={this.removeCrop} data-id={i} className={"btn btn-danger btn-sm"}>remove</i>
                                        </div>
                                    </div>
                                )
                                :null
                        }

                        {
                            this.state.items.length!=0 ?
                                this.state.items.map((item,i)=>

                                    <div className={item.is_main==1 ? "itemGallery main" : "itemGallery"} key={item.id}>
                                        {/*<SortableItem key={`item-${i}`} index={i} value={item} />*/}
                                        <div className={item.is_main==1 ? "image main" : "image"}>
                                            <img src={`${this.state.host}/${item.thumb_path}`} className={"image"}/>
                                            <div className="btn-group" role="group" aria-label="Basic example">
                                                <i onClick={this.removeFromDB} data-id={item.id} className={"btn btn-danger btn-sm"}>Удалить</i>
                                                <i onClick={this.mainImage} data-id={item.id} className={"btn btn-success btn-sm"}>Главная</i>
                                            </div>
                                        </div>
                                        <div className={'info'}>

                                            <form onSubmit={this.handleSubmitMeta} data-id={item.id}>
                                                <input type="text" defaultValue={item.alt} className={'form-control alt'} placeholder={'Alt'}/>
                                                <input type="text" defaultValue={item.title} className={'form-control title'} placeholder={'Title'}/>
                                                <input type="submit" value="Сохранить" className={"btn btn-danger btn-sm"}/>
                                            </form>
                                        </div>
                                    </div>
                                )
                                :null
                        }

                        {/*<span id="uploadText" onClick={this.showOpenFileDlg}>Выбрать файл</span>*/}

                    </div>  }

            </div>
        )
    }


    componentDidMount(){
        if(NODE_ENV==="development") {

        }
        if(this.state.id!=null){
            Ajax({
                "url":`/gallery/base/data`,
                "method":'GET',
                "csrf":true,
                "data":{
                    id : this.state.id,
                    type : this.state.type
                }
            }).then(res =>{
                if(res) {
                    this.setState({
                        items : [...res.response.data],
                    })
                }

                if(NODE_ENV==="development") {
                    console.log('------get all list company data-------',res.response);
                }


            }).catch(res=>{

            })
        }


    }

    changePreloader = () =>{
        this.setState({
            preloader:false
        })
    }

    //set base64 crop item into storage
    setCropData = (file) => {
        this.setState({
            data : [...this.state.data,file],
            cropModal:false
        })
        console.log(file);
    }

    //get foto base64 for crop


    handleFiles = (files) => {
        let img =  new Image();
        //let crope = this.props.image
        img.src = files.base64;
        img.onload = () => {
            const x = img.width;
            const y = img.height;
            var imgSize=[];
            if(x>y) imgSize = [700,500];
            else  imgSize = [275,600];

            if(window.innerWidth<700) imgSize = ["100%",600];

            if (x>300 && y>300) {
                this.setState({
                    item:files.base64,
                    size:imgSize,
                    cropModal:true,
                })
            }
            else{
                this.message("The size of image must be more then 300*300");
            }

        }
    }


    onSortEnd = ({oldIndex, newIndex}) => {
        console.log( oldIndex, newIndex)
        // this.setState(({items}) => ({
        //     items: arrayMove(items, oldIndex, newIndex),
        // }));
    };

    mainImage = (e) =>{
        console.log('remove');
        Ajax({
            "url":`/gallery/base/main`,
            "method":'GET',
            "csrf":true,
            "data":{
                id : e.currentTarget.getAttribute('data-id'),
            }
        }).then(res =>{
            console.log(res.response)
            if(res.response.status){
                this.message(res.response.message);
            }
        })
    }

    removeFromDB = (e) =>{
        let id = e.currentTarget.getAttribute('data-id');
        const data = this.state.items.filter((item,i) => item.id != id);
        console.log('remove');
        Ajax({
            "url":`/gallery/base/remove`,
            "method":'GET',
            "csrf":true,
            "data":{
                id : id,
            }
        }).then(res =>{
            if(res.response.status){
                this.setState({items:data})
                this.message(res.response.message);
            }
        });


    }

    removeCrop = (e) =>{
        let id = e.currentTarget.getAttribute('data-id');
        const data = this.state.data.filter((item,i) => i != id);
        console.log(id,data);
        this.setState({data:data})
    }

    handleSubmitMeta = (e) => {
        e.preventDefault();
        let id = e.currentTarget.getAttribute('data-id');
        let alt = e.currentTarget.querySelector('.alt').value;
        let title = e.currentTarget.querySelector('.title').value;
        console.log(alt,title)
        Ajax({
            "url":`/gallery/base/meta`,
            "method":'GET',
            "csrf":true,
            "data":{
                id : id,
                alt : alt,
                title : title
            }
        }).then(res =>{
            if(res.response.status){
                this.message(res.response.message);
            }
            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res.response);
            }


        })
    }

    message = (m) =>{
        this.setState({
            hideMessage:false,
            textMessage:m
        })

        this.timeOut(3000)
    }

    timeOut = (delay) =>{
        setTimeout(()=>{this.setState({hideMessage:true})
                    },delay)
    }







}