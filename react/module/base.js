import React,{Component} from "react";
import ReactDOM from 'react-dom';
import Top from './gallery/top';
import Ajax from './../module/ajax/index';
import Cropper from './gallery/cropper'
import ReactFileReader from 'react-file-reader';
import Message from './gallery/message';
import Preloader from './gallery/preloader';
import Form from './gallery/form';

export default class Base extends Component {

    constructor(props){
        super(props);
        let elem = document.getElementById('gallery');
        this.state = {
            //entity:document.getElementById('allComments').getAttribute('data-entity'),
            data:[],
            item:[],
            cropModal:false,

            id :    elem !=undefined ?   elem.getAttribute('data-id') : null,
            type :  elem !=undefined ?   elem.getAttribute('data-type') : null,
            max :   elem !=undefined ?   elem.getAttribute('data-max') : null,
            host :   elem !=undefined ?   elem.getAttribute('data-host') : null,

            entity : 123,
            hideMessage:true,
            totalShow : 3,
            textMessage:'',
            files:[],

            items : [],
            previewData:null,
            showAll:false,
            preloader:false
        }

        //this.inputOpenFileRef = React.createRef()

    }

    render(){
        const data = this.state.files.length!=0 ? this.state.files : null;
        console.log(data);
        return (

            <div className="gallery">
                {/*{this.state.previewData == null ? <p>Комментариев пока не найдено</p> : null}*/}
                {this.state.preloader ? <Preloader /> :

                    <div>

                        {this.state.cropModal ?
                            <div className="col-md-12">
                                <Cropper image={this.state.item} setData={this.setCropData}/>
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
                                        <img src={item.base64} className={"image"}/>
                                        <i onClick={this.removeCrop} data-id={i}>remove</i>
                                    </div>
                                )
                                :null
                        }

                        {
                            this.state.items.length!=0 ?
                                this.state.items.map((item,i)=>
                                    <div className={"itemGallery"} key={item.id}>
                                        <img src={`${this.state.host}/${item.thumb_path}`} className={"image"}/>
                                        <i onClick={this.removeFromDB} data-id={item.id}>remove</i>
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
                this.setState({
                    items : [...res.response.data],
                })
                if(NODE_ENV==="development") {
                    console.log('------get all list company data-------',res.response);
                }


            })
        }


    }

    changePreloader = () =>{
        this.setState({
            preloader:false
        })
    }

    setCropData = (file) => {
        this.setState({
            data : [...this.state.data,file],
            cropModal:false
        })
        console.log(file);
    }

    handleFiles = (files) => {
        this.setState({
            item:files.base64,
            cropModal:true,
        })
    }




    getAllData = () =>{
        Ajax({
            "url":`/comments/default/get-all`,
            "method":'GET',
            "csrf":true,
            "headers": 0, //Показать заголовки ответа
            "data":{entity:this.state.entity}
        }).then(res =>{

            this.setState({
                data : [...res.response.data],
                showAll:true,
                preloader:false
            })

            if(NODE_ENV==="development") {
                console.log('------get all list company data-------',res);
            }
        })

    }

    removeFromDB = (e) =>{
        let id = e.currentTarget.getAttribute('data-id');
        const data = this.state.items.filter((item,i) => item.id != id);
        console.log('db',id,data);
        this.setState({items:data})

    }

    removeCrop = (e) =>{
        let id = e.currentTarget.getAttribute('data-id');
        const data = this.state.data.filter((item,i) => i != id);
        console.log(id,data);
        this.setState({data:data})
    }


    showMore = () => {
        console.log('more')
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