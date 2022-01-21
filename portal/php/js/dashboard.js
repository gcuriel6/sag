// JavaScript Document
	function AnimateDB(forma,x,y,active){
		
		var t='slow';
		var y1= (y -1)+'%';
		var y2= (90 -y)+'%';
		
		var x1= (x -1)+'%';
		var x2= (90 -x)+'%';
		switch(forma){
			case '-':
				$('#box1').animate({width:'90%',height:y1},t);
				$('#box2').animate({width:'0%',height:'0%'},t);
				$('#box3').animate({width:'90%',height:y2},t);
				$('#box4').animate({width:'0%',height:'0%'},t);
			break;
			case 'T':
				$('#box1').animate({width:'90%',height:y1},t);
				$('#box2').animate({width:'0%',height:'0%'},t);
				$('#box3').animate({width:x1,height:y2},t);
				$('#box4').animate({width:x2,height:y2},t);
			break;
			case '+':
				$('#box1').animate({width:x1,height:y1},t);
				$('#box2').animate({width:x2,height:y1},t);
				$('#box3').animate({width:x1,height:y2},t);
				$('#box4').animate({width:x2,height:y2},t);
			break;
			case 'L':
				$('#box1').animate({width:x1,height:y1},t);
				$('#box2').animate({width:x2,height:y1},t);
				$('#box3').animate({width:'90%',height:y2},t);
				$('#box4').animate({width:'0%',height:'0%'},t);
			break;
			case '1':
				$('#box1').animate({width:x1,height:'90%'},t);
				$('#box2').animate({width:x2,height:'90%'},t);
				$('#box3').animate({width:'0%',height:'0%'},t);
				$('#box4').animate({width:'0%',height:'0%'},t);
			break;
			case '0':
				switch(active)
				{
				case '2':
					$('#box1').animate({width:'0%',height:'0%'},t);
					$('#box2').animate({width:'90%',height:'90%'},t);
					$('#box3').animate({width:'0%',height:'0%'},t);
					$('#box4').animate({width:'0%',height:'0%'},t);
				break;
				
				case '1':
					$('#box1').animate({width:'90%',height:'90%'},t);
					$('#box2').animate({width:'0%',height:'0%'},t);
					$('#box3').animate({width:'0%',height:'0%'},t);
					$('#box4').animate({width:'0%',height:'0%'},t);
					break;
					
				case '3':
					$('#box1').animate({width:'0%',height:'0%'},t);
					$('#box2').animate({width:'0%',height:'0%'},t);
					$('#box3').animate({width:'90%',height:'90%'},t);
					$('#box4').animate({width:'0%',height:'0%'},t);
					break;
				case '4':
					$('#box1').animate({width:'0%',height:'0%'},t);
					$('#box2').animate({width:'0%',height:'0%'},t);
					$('#box3').animate({width:'0%',height:'0%'},t);
					$('#box4').animate({width:'90%',height:'90%'},t);
					break;
				}
			break;
			case '<':
				$('#box1').animate({width:x1,height:y1},t);
				$('#box2').animate({width:x2,height:'90%'},t);
				$('#box3').animate({width:x1,height:y2},t);
				$('#box4').animate({width:'0%',height:'0%'},t);
			break;
			case '>':
				$('#box1').animate({width:x1,height:'90%'},t);
				$('#box2').animate({width:x2,height:y1},t);
				$('#box3').animate({width:'0%',height:'0%'},t);
				$('#box4').animate({width:x2,height:y2},t);
			break;
		}
	}