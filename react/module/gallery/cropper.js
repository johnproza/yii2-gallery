import React, {Component} from 'react';
import Cropper from 'react-cropper';
//import 'cropperjs/dist/cropper.css';
//var Cropper = require('react-cropper').default;
var size=[];
export  default class Crop extends Component {
    constructor(props) {
        super(props);
        this.cropper = React.createRef();
        this.alt = React.createRef();
        this.title = React.createRef();


    }

    crop = () => {
        this.props.setData({
            base64 : this.cropper.current.getCroppedCanvas().toDataURL(),
            url : this.cropper.current.getCroppedCanvas().toDataURL(),
            //url : this.decode_base64(this.cropper.current.getCroppedCanvas().toDataURL()),
            //alt : this.alt.current.value,
            //title :this.title.current.value
        })

    }


    render() {

        const aspectRatio = this.props.aspectRatio.split('/');



        return (
            <div style={{width: '100%'}}>
                <Cropper
                    ref={this.cropper}
                    style={{ width: this.props.size[0], height:this.props.size[1], background:'#fff'}}
                    src={this.props.image}
                    modal={true}
                    center={true}
                    background={false}
                    zoomable={false}
                    zoomOnWheel={false}
                    //aspectRatio={1 / 1}
                    aspectRatio={ aspectRatio[0] / aspectRatio[1]}
                    guides={false}
                    //crop={this.crop}
                    viewMode={2}
                />
                <input type='button' name='send' defaultValue={'Обрезать'} onClick={this.crop} className={'btn btn-danger btn-md'} style={{margin: '20px'}}/>

            </div>
        );



    }
}