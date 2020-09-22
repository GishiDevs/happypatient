<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Web 1920 – 1</title>
<style id="applicationStylesheet" type="text/css">
	.mediaViewInfo {
		--web-view-name: Web 1920 – 1;
		--web-view-id: Web_1920__1;
		--web-scale-to-fit: true;
		--web-scale-to-fit-type: width;
		--web-scale-on-resize: true;
		--web-center-vertically: true;
		--web-enable-deep-linking: true;
	}
	:root {
		--web-view-ids: Web_1920__1;
	}
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		border: none;
	}
	#Web_1920__1 {
		position: absolute;
		width: 1080px;
		height: 1920px;
		background-color: rgba(255,255,255,1);
		overflow: hidden;
		--web-view-name: Web 1920 – 1;
		--web-view-id: Web_1920__1;
		--web-scale-to-fit: true;
		--web-scale-to-fit-type: width;
		--web-scale-on-resize: true;
		--web-center-vertically: true;
		--web-enable-deep-linking: true;
	}
	#siteicon {
		position: absolute;
		width: 105px;
		height: 159px;
		left: 46px;
		top: 55px;
		overflow: visible;
	}
	#HAPPY {
		left: 242px;
		top: 48px;
		position: absolute;
		overflow: visible;
		width: 278px;
		white-space: nowrap;
		text-align: right;
		font-family: Rockwell;
		font-style: normal;
		font-weight: bold;
		font-size: 75px;
		color: rgba(109,45,159,1);
		letter-spacing: 0.5px;
	}
	#Diagnostic_Clinic {
		left: 220px;
		top: 175px;
		position: absolute;
		overflow: visible;
		width: 304px;
		height: 50px;
		text-align: left;
		font-family: Vivaldi;
		font-style: normal;
		font-weight: normal;
		font-size: 40px;
		color: rgba(5,109,198,1);
		letter-spacing: 1px;
	}
	#X-ray_-_Ultrasound_-_Laborator {
		left: 543px;
		top: 69px;
		position: absolute;
		overflow: visible;
		width: 473px;
		white-space: nowrap;
		line-height: 36px;
		margin-top: -10px;
		text-align: center;
		font-family: Gilroy;
		font-style: normal;
		font-weight: normal;
		font-size: 16px;
		color: rgba(0,0,0,1);
	}
	#ID2nd_Floor_Friendship_Superma {
		left: 543px;
		top: 94px;
		position: absolute;
		overflow: visible;
		width: 472px;
		white-space: nowrap;
		line-height: 20px;
		margin-top: -3px;
		text-align: left;
		font-family: Candara;
		font-style: normal;
		font-weight: normal;
		font-size: 14px;
		color: rgba(35,35,35,1);
	}
	#Line_1 {
		fill: transparent;
		stroke: rgba(0,0,0,1);
		stroke-width: 2px;
		stroke-linejoin: miter;
		stroke-linecap: butt;
		stroke-miterlimit: 4;
		shape-rendering: auto;
	}
	.Line_1 {
		overflow: visible;
		position: absolute;
		width: 2px;
		height: 144px;
		left: 531.5px;
		top: 69.5px;
		transform: matrix(1,0,0,1,0,0);
	}
	#Rectangle_1 {
		fill: rgba(217,217,217,1);
	}
	.Rectangle_1 {
		position: absolute;
		overflow: visible;
		width: 472px;
		height: 57px;
		left: 543px;
		top: 157px;
	}
	#RADIOLOGY_REPORT {
		left: 668px;
		top: 174px;
		position: absolute;
		overflow: visible;
		width: 213px;
		white-space: nowrap;
		line-height: 56px;
		margin-top: -18px;
		text-align: right;
		font-family: Maiandra GD;
		font-style: normal;
		font-weight: normal;
		font-size: 20px;
		color: rgba(11,3,255,1);
		letter-spacing: 0.5px;
		text-transform: uppercase;
	}
	#PATIENT {
		left: 152px;
		top: 106px;
		position: absolute;
		overflow: visible;
		width: 369px;
		white-space: nowrap;
		text-align: right;
		font-family: Rockwell;
		font-style: normal;
		font-weight: bold;
		font-size: 75px;
		color: rgba(251,1,2,1);
		letter-spacing: 0.5px;
	}
</style>
<script id="applicationScript">
///////////////////////////////////////
// INITIALIZATION
///////////////////////////////////////

/**
 * Functionality for scaling, showing by media query, and navigation between multiple pages on a single page. 
 * Code subject to change.
 **/

if (window.console==null) { window["console"] = { log : function() {} } }; // some browsers do not set console

var Application = function() {
	// event constants
	this.prefix = "--web-";
	this.NAVIGATION_CHANGE = "viewChange";
	this.VIEW_NOT_FOUND = "viewNotFound";
	this.VIEW_CHANGE = "viewChange";
	this.VIEW_CHANGING = "viewChanging";
	this.STATE_NOT_FOUND = "stateNotFound";
	this.APPLICATION_COMPLETE = "applicationComplete";
	this.APPLICATION_RESIZE = "applicationResize";
	this.SIZE_STATE_NAME = "data-is-view-scaled";
	this.STATE_NAME = this.prefix + "state";

	this.lastTrigger = null;
	this.lastView = null;
	this.lastState = null;
	this.lastOverlay = null;
	this.currentView = null;
	this.currentState = null;
	this.currentOverlay = null;
	this.currentQuery = {index: 0, rule: null, mediaText: null, id: null};
	this.inclusionQuery = "(min-width: 0px)";
	this.exclusionQuery = "none and (min-width: 99999px)";
	this.LastModifiedDateLabelName = "LastModifiedDateLabel";
	this.viewScaleSliderId = "ViewScaleSliderInput";
	this.pageRefreshedName = "showPageRefreshedNotification";
	this.applicationStylesheet = null;
	this.mediaQueryDictionary = {};
	this.viewsDictionary = {};
	this.addedViews = [];
	this.views = {};
	this.viewIds = [];
	this.viewQueries = {};
	this.overlays = {};
	this.overlayIds = [];
	this.numberOfViews = 0;
	this.verticalPadding = 0;
	this.horizontalPadding = 0;
	this.stateName = null;
	this.viewScale = 1;
	this.viewLeft = 0;
	this.viewTop = 0;
	this.horizontalScrollbarsNeeded = false;
	this.verticalScrollbarsNeeded = false;

	// view settings
	this.showUpdateNotification = false;
	this.showNavigationControls = false;
	this.scaleViewsToFit = false;
	this.scaleToFitOnDoubleClick = false;
	this.actualSizeOnDoubleClick = false;
	this.scaleViewsOnResize = false;
	this.navigationOnKeypress = false;
	this.showViewName = false;
	this.enableDeepLinking = true;
	this.refreshPageForChanges = false;
	this.showRefreshNotifications = true;

	// view controls
	this.scaleViewSlider = null;
	this.lastModifiedLabel = null;
	this.supportsPopState = false; // window.history.pushState!=null;
	this.initialized = false;

	// refresh properties
	this.refreshDuration = 250;
	this.lastModifiedDate = null;
	this.refreshRequest = null;
	this.refreshInterval = null;
	this.refreshContent = null;
	this.refreshContentSize = null;
	this.refreshCheckContent = false;
	this.refreshCheckContentSize = false;

	var self = this;

	self.initialize = function(event) {
		var view = self.getVisibleView();
		var views = self.getVisibleViews();
		if (view==null) view = self.getInitialView();
		self.collectViews();
		self.collectOverlays();
		self.collectMediaQueries();

		for (let index = 0; index < views.length; index++) {
			var view = views[index];
			self.setViewOptions(view);
			self.setViewVariables(view);
			self.centerView(view);
		}

		// sometimes the body size is 0 so we call this now and again later
		if (self.initialized) {
			window.addEventListener(self.NAVIGATION_CHANGE, self.viewChangeHandler);
			window.addEventListener("keyup", self.keypressHandler);
			window.addEventListener("keypress", self.keypressHandler);
			window.addEventListener("resize", self.resizeHandler);
			window.document.addEventListener("dblclick", self.doubleClickHandler);

			if (self.supportsPopState) {
				window.addEventListener('popstate', self.popStateHandler);
			}
			else {
				window.addEventListener('hashchange', self.hashChangeHandler);
			}

			// we are ready to go
			window.dispatchEvent(new Event(self.APPLICATION_COMPLETE));
		}

		if (self.initialized==false) {
			if (self.enableDeepLinking) {
				self.syncronizeViewToURL();
			} 
	
			if (self.refreshPageForChanges) {
				self.setupRefreshForChanges();
			}
	
			self.initialized = true;
		}
		
		if (self.scaleViewsToFit) {
			self.viewScale = self.scaleViewToFit(view);
			
			if (self.viewScale<0) {
				setTimeout(self.scaleViewToFit, 500, view);
			}
		}
		else if (view) {
			self.viewScale = self.getViewScaleValue(view);
			self.centerView(view);
			self.updateSliderValue(self.viewScale);
		}
		else {
			// no view found
		}
	
		if (self.showUpdateNotification) {
			self.showNotification();
		}

		//"addEventListener" in window ? null : window.addEventListener = window.attachEvent;
		//"addEventListener" in document ? null : document.addEventListener = document.attachEvent;
	}


	///////////////////////////////////////
	// AUTO REFRESH 
	///////////////////////////////////////

	self.setupRefreshForChanges = function() {
		self.refreshRequest = new XMLHttpRequest();

		if (!self.refreshRequest) {
			return false;
		}

		// get document start values immediately
		self.requestRefreshUpdate();
	}

	/**
	 * Attempt to check the last modified date by the headers 
	 * or the last modified property from the byte array (experimental)
	 **/
	self.requestRefreshUpdate = function() {
		var url = document.location.href;
		var protocol = window.location.protocol;
		var method;
		
		try {

			if (self.refreshCheckContentSize) {
				self.refreshRequest.open('HEAD', url, true);
			}
			else if (self.refreshCheckContent) {
				self.refreshContent = document.documentElement.outerHTML;
				self.refreshRequest.open('GET', url, true);
				self.refreshRequest.responseType = "text";
			}
			else {

				// get page last modified date for the first call to compare to later
				if (self.lastModifiedDate==null) {

					// File system does not send headers in FF so get blob if possible
					if (protocol=="file:") {
						self.refreshRequest.open("GET", url, true);
						self.refreshRequest.responseType = "blob";
					}
					else {
						self.refreshRequest.open("HEAD", url, true);
						self.refreshRequest.responseType = "blob";
					}

					self.refreshRequest.onload = self.refreshOnLoadOnceHandler;

					// In some browsers (Chrome & Safari) this error occurs at send: 
					// 
					// Chrome - Access to XMLHttpRequest at 'file:///index.html' from origin 'null' 
					// has been blocked by CORS policy: 
					// Cross origin requests are only supported for protocol schemes: 
					// http, data, chrome, chrome-extension, https.
					// 
					// Safari - XMLHttpRequest cannot load file:///Users/user/Public/index.html. Cross origin requests are only supported for HTTP.
					// 
					// Solution is to run a local server, set local permissions or test in another browser
					self.refreshRequest.send(null);

					// In MS browsers the following behavior occurs possibly due to an AJAX call to check last modified date: 
					// 
					// DOM7011: The code on this page disabled back and forward caching.

					// In Brave (Chrome) error when on the server
					// index.js:221 HEAD https://www.example.com/ net::ERR_INSUFFICIENT_RESOURCES
					// self.refreshRequest.send(null);

				}
				else {
					self.refreshRequest = new XMLHttpRequest();
					self.refreshRequest.onreadystatechange = self.refreshHandler;
					self.refreshRequest.ontimeout = function() {
						self.log("Couldn't find page to check for updates");
					}
					
					var method;
					if (protocol=="file:") {
						method = "GET";
					}
					else {
						method = "HEAD";
					}

					//refreshRequest.open('HEAD', url, true);
					self.refreshRequest.open(method, url, true);
					self.refreshRequest.responseType = "blob";
					self.refreshRequest.send(null);
				}
			}
		}
		catch (error) {
			self.log("Refresh failed for the following reason:")
			self.log(error);
		}
	}

	self.refreshHandler = function() {
		var contentSize;

		try {

			if (self.refreshRequest.readyState === XMLHttpRequest.DONE) {
				
				if (self.refreshRequest.status === 2 || 
					self.refreshRequest.status === 200) {
					var pageChanged = false;

					self.updateLastModifiedLabel();

					if (self.refreshCheckContentSize) {
						var lastModifiedHeader = self.refreshRequest.getResponseHeader("Last-Modified");
						contentSize = self.refreshRequest.getResponseHeader("Content-Length");
						//lastModifiedDate = refreshRequest.getResponseHeader("Last-Modified");
						var headers = self.refreshRequest.getAllResponseHeaders();
						var hasContentHeader = headers.indexOf("Content-Length")!=-1;
						
						if (hasContentHeader) {
							contentSize = self.refreshRequest.getResponseHeader("Content-Length");

							// size has not been set yet
							if (self.refreshContentSize==null) {
								self.refreshContentSize = contentSize;
								// exit and let interval call this method again
								return;
							}

							if (contentSize!=self.refreshContentSize) {
								pageChanged = true;
							}
						}
					}
					else if (self.refreshCheckContent) {

						if (self.refreshRequest.responseText!=self.refreshContent) {
							pageChanged = true;
						}
					}
					else {
						lastModifiedHeader = self.getLastModified(self.refreshRequest);

						if (self.lastModifiedDate!=lastModifiedHeader) {
							self.log("lastModifiedDate:" + self.lastModifiedDate + ",lastModifiedHeader:" +lastModifiedHeader);
							pageChanged = true;
						}

					}

					
					if (pageChanged) {
						clearInterval(self.refreshInterval);
						self.refreshUpdatedPage();
						return;
					}

				}
				else {
					self.log('There was a problem with the request.');
				}

			}
		}
		catch( error ) {
			//console.log('Caught Exception: ' + error);
		}
	}

	self.refreshOnLoadOnceHandler = function(event) {

		// get the last modified date
		if (self.refreshRequest.response) {
			self.lastModifiedDate = self.getLastModified(self.refreshRequest);

			if (self.lastModifiedDate!=null) {

				if (self.refreshInterval==null) {
					self.refreshInterval = setInterval(self.requestRefreshUpdate, self.refreshDuration);
				}
			}
			else {
				self.log("Could not get last modified date from the server");
			}
		}
	}

	self.refreshUpdatedPage = function() {
		if (self.showRefreshNotifications) {
			var date = new Date().setTime((new Date().getTime()+10000));
			document.cookie = encodeURIComponent(self.pageRefreshedName) + "=true" + "; max-age=6000;" + " path=/";
		}

		document.location.reload(true);
	}

	self.showNotification = function(duration) {
		var notificationID = self.pageRefreshedName+"ID";
		var notification = document.getElementById(notificationID);
		if (duration==null) duration = 4000;

		if (notification!=null) {return;}

		notification = document.createElement("div");
		notification.id = notificationID;
		notification.textContent = "PAGE UPDATED";
		var styleRule = ""
		styleRule = "position: fixed; padding: 7px 16px 6px 16px; font-family: Arial, sans-serif; font-size: 10px; font-weight: bold; left: 50%;";
		styleRule += "top: 20px; background-color: rgba(0,0,0,.5); border-radius: 12px; color:rgb(235, 235, 235); transition: all 2s linear;";
		styleRule += "transform: translateX(-50%); letter-spacing: .5px; filter: drop-shadow(2px 2px 6px rgba(0, 0, 0, .1))";
		notification.setAttribute("style", styleRule);

		notification.className= "PageRefreshedClass";
		
		document.body.appendChild(notification);

		setTimeout(function() {
			notification.style.opacity = "0";
			notification.style.filter = "drop-shadow( 0px 0px 0px rgba(0,0,0, .5))";
			setTimeout(function() {
				notification.parentNode.removeChild(notification);
			}, duration)
		}, duration);

		document.cookie = encodeURIComponent(self.pageRefreshedName) + "=; max-age=1; path=/";
	}

	/**
	 * Get the last modified date from the header 
	 * or file object after request has been received
	 **/
	self.getLastModified = function(request) {
		var date;

		// file protocol - FILE object with last modified property
		if (request.response && request.response.lastModified) {
			date = request.response.lastModified;
		}
		
		// http protocol - check headers
		if (date==null) {
			date = request.getResponseHeader("Last-Modified");
		}

		return date;
	}

	self.updateLastModifiedLabel = function() {
		var labelValue = "";
		
		if (self.lastModifiedLabel==null) {
			self.lastModifiedLabel = document.getElementById("LastModifiedLabel");
		}

		if (self.lastModifiedLabel) {
			var seconds = parseInt(((new Date().getTime() - Date.parse(document.lastModified)) / 1000 / 60) * 100 + "");
			var minutes = 0;
			var hours = 0;

			if (seconds < 60) {
				seconds = Math.floor(seconds/10)*10;
				labelValue = seconds + " seconds";
			}
			else {
				minutes = parseInt((seconds/60) + "");

				if (minutes>60) {
					hours = parseInt((seconds/60/60) +"");
					labelValue += hours==1 ? " hour" : " hours";
				}
				else {
					labelValue = minutes+"";
					labelValue += minutes==1 ? " minute" : " minutes";
				}
			}
			
			if (seconds<10) {
				labelValue = "Updated now";
			}
			else {
				labelValue = "Updated " + labelValue + " ago";
			}

			if (self.lastModifiedLabel.firstElementChild) {
				self.lastModifiedLabel.firstElementChild.textContent = labelValue;

			}
			else if ("textContent" in self.lastModifiedLabel) {
				self.lastModifiedLabel.textContent = labelValue;
			}
		}
	}

	self.getShortString = function(string, length) {
		if (length==null) length = 30;
		string = string!=null ? string.substr(0, length).replace(/\n/g, "") : "[String is null]";
		return string;
	}

	self.getShortNumber = function(value, places) {
		if (places==null || places<1) places = 4;
		value = Math.round(value * Math.pow(10,places)) / Math.pow(10, places);
		return value;
	}

	///////////////////////////////////////
	// NAVIGATION CONTROLS
	///////////////////////////////////////

	self.updateViewLabel = function() {
		var viewNavigationLabel = document.getElementById("ViewNavigationLabel");
		var view = self.getVisibleView();
		var viewIndex = view ? self.getViewIndex(view) : -1;
		var viewName = view ? self.getViewPreferenceValue(view, self.prefix + "view-name") : null;
		var viewId = view ? view.id : null;

		if (viewNavigationLabel && view) {
			if (viewName && viewName.indexOf('"')!=-1) {
				viewName = viewName.replace(/"/g, "");
			}

			if (self.showViewName) {
				viewNavigationLabel.textContent = viewName;
				self.setTooltip(viewNavigationLabel, viewIndex + 1 + " of " + self.numberOfViews);
			}
			else {
				viewNavigationLabel.textContent = viewIndex + 1 + " of " + self.numberOfViews;
				self.setTooltip(viewNavigationLabel, viewName);
			}

		}
	}

	self.updateURL = function(view) {
		view = view == null ? self.getVisibleView() : view;
		var viewId = view ? view.id : null
		var viewFragment = view ? "#"+ viewId : null;

		if (viewId && self.viewIds.length>1 && self.enableDeepLinking) {

			if (self.supportsPopState==false) {
				self.setFragment(viewId);
			}
			else {
				if (viewFragment!=window.location.hash) {

					if (window.location.hash==null) {
						window.history.replaceState({name:viewId}, null, viewFragment);
					}
					else {
						window.history.pushState({name:viewId}, null, viewFragment);
					}
				}
			}
		}
	}

	self.updateURLState = function(view, stateName) {
		stateName = view && (stateName=="" || stateName==null) ? self.getStateNameByViewId(view.id) : stateName;

		if (self.supportsPopState==false) {
			self.setFragment(stateName);
		}
		else {
			if (stateName!=window.location.hash) {

				if (window.location.hash==null) {
					window.history.replaceState({name:view.viewId}, null, stateName);
				}
				else {
					window.history.pushState({name:view.viewId}, null, stateName);
				}
			}
		}
	}

	self.setFragment = function(value) {
		window.location.hash = "#" + value;
	}

	self.setTooltip = function(element, value) {
		// setting the tooltip in edge causes a page crash on hover
		if (/Edge/.test(navigator.userAgent)) { return; }

		if ("title" in element) {
			element.title = value;
		}
	}

	self.getStylesheetRules = function(styleSheet) {
		try {
			if (styleSheet) return styleSheet.cssRules || styleSheet.rules;
	
			return document.styleSheets[0]["cssRules"] || document.styleSheets[0]["rules"];
		}
		catch (error) {
			// ERRORS:
			// SecurityError: The operation is insecure.
			// Errors happen when script loads before stylesheet or loading an external css locally

			// InvalidAccessError: A parameter or an operation is not supported by the underlying object
			// Place script after stylesheet

			console.log(error);
			if (error.toString().indexOf("The operation is insecure")!=-1) {
				console.log("Load the stylesheet before the script or load the stylesheet inline until it can be loaded on a server")
			}
			return [];
		}
	}

	/**
	 * If single page application hide all of the views. 
	 * @param {Number} selectedIndex if provided shows the view at index provided
	 **/
	self.hideViews = function(selectedIndex, animation) {
		var rules = self.getStylesheetRules();
		var queryIndex = 0;
		var numberOfRules = rules!=null ? rules.length : 0;

		// loop through rules and hide media queries except selected
		for (var i=0;i<numberOfRules;i++) {
			var rule = rules[i];

			if (rule.media!=null) {

				if (queryIndex==selectedIndex) {
					self.currentQuery.mediaText = rule.conditionText;
					self.currentQuery.index = selectedIndex;
					self.currentQuery.rule = rule;
					self.enableMediaQuery(rule);
				}
				else {
					if (animation) {
						self.fadeOut(rule)
					}
					else {
						self.disableMediaQuery(rule);
					}
				}
				
				queryIndex++;
			}
		}

		self.numberOfViews = queryIndex;
		self.updateViewLabel();
		self.updateURL();

		self.dispatchViewChange();

		var view = self.getVisibleView();
		var viewIndex = view ? self.getViewIndex(view) : -1;

		return viewIndex==selectedIndex ? view : null;
	}

	/**
	 * Hide view
	 * @param {Object} view element to hide
	 **/
	self.hideView = function(view) {
		var rule = view ? self.mediaQueryDictionary[view.id] : null;

		if (rule) {
			self.disableMediaQuery(rule);
		}
	}

	/**
	 * Hide overlay
	 * @param {Object} overlay element to hide
	 **/
	self.hideOverlay = function(overlay) {
		var rule = overlay ? self.mediaQueryDictionary[overlay.id] : null;

		if (rule) {
			self.disableMediaQuery(rule);

			//if (self.showByMediaQuery) {
				overlay.style.display = "none";
			//}
		}
	}

	/**
	 * Show the view by media query. Does not hide current views
	 * Sets view options by default
	 * @param {Object} view element to show
	 * @param {Boolean} setViewOptions sets view options if null or true
	 */
	self.showViewByMediaQuery = function(view, setViewOptions) {
		var id = view ? view.id : null;
		var query = id ? self.mediaQueryDictionary[id] : null;
		var isOverlay = view ? self.isOverlay(view) : false;
		setViewOptions = setViewOptions==null ? true : setViewOptions;

		if (query) {
			self.enableMediaQuery(query);

			if (isOverlay && view && setViewOptions) {
				self.setViewVariables(null, view);
			}
			else {
				if (view && setViewOptions) self.setViewOptions(view);
				if (view && setViewOptions) self.setViewVariables(view);
			}
		}
	}

	/**
	 * Show the view. Does not hide current views
	 */
	self.showView = function(view, setViewOptions) {
		var id = view ? view.id : null;
		var query = id ? self.mediaQueryDictionary[id] : null;
		var display = null;
		setViewOptions = setViewOptions==null ? true : setViewOptions;

		if (query) {
			self.enableMediaQuery(query);
			if (view==null) view =self.getVisibleView();
			if (view && setViewOptions) self.setViewOptions(view);
		}
		else if (id) {
			display = window.getComputedStyle(view).getPropertyValue("display");
			if (display=="" || display=="none") {
				view.style.display = "block";
			}
		}

		if (view) {
			if (self.currentView!=null) {
				self.lastView = self.currentView;
			}

			self.currentView = view;
		}
	}

	self.showViewById = function(id, setViewOptions) {
		var view = id ? self.getViewById(id) : null;

		if (view) {
			self.showView(view);
			return;
		}

		self.log("View not found '" + id + "'");
	}

	self.getElementView = function(element) {
		var view = element;
		var viewFound = false;

		while (viewFound==false || view==null) {
			if (view && self.viewsDictionary[view.id]) {
				return view;
			}
			view = view.parentNode;
		}
	}

	/**
	 * Show overlay over view
	 * @param {Event | HTMLElement} event event or html element with styles applied
	 * @param {String} id id of view or view reference
	 * @param {Number} x x location
	 * @param {Number} y y location
	 */
	self.showOverlay = function(event, id, x, y) {
		var overlay = id && typeof id === 'string' ? self.getViewById(id) : id ? id : null;
		var query = overlay ? self.mediaQueryDictionary[overlay.id] : null;
		var centerHorizontally = false;
		var centerVertically = false;
		var anchorLeft = false;
		var anchorTop = false;
		var anchorRight = false;
		var anchorBottom = false;
		var display = null;
		var reparent = true;
		var view = null;
		
		if (overlay==null || overlay==false) {
			self.log("Overlay not found, '"+ id + "'");
			return;
		}

		// get enter animation - event target must have css variables declared
		if (event) {
			var button = event.currentTarget || event; // can be event or htmlelement
			var buttonComputedStyles = getComputedStyle(button);
			var actionTargetValue = buttonComputedStyles.getPropertyValue(self.prefix+"action-target").trim();
			var animation = buttonComputedStyles.getPropertyValue(self.prefix+"animation").trim();
			var isAnimated = animation!="";
			var targetType = buttonComputedStyles.getPropertyValue(self.prefix+"action-type").trim();
			var actionTarget = self.application ? null : self.getElement(actionTargetValue);
			var actionTargetStyles = actionTarget ? actionTarget.style : null;

			if (actionTargetStyles) {
				actionTargetStyles.setProperty("animation", animation);
			}

			if ("stopImmediatePropagation" in event) {
				event.stopImmediatePropagation();
			}
		}
		
		if (self.application==false || targetType=="page") {
			document.location.href = "./" + actionTargetValue;
			return;
		}

		// remove any current overlays
		if (self.currentOverlay) {

			// act as switch if same button
			if (self.currentOverlay==actionTarget || self.currentOverlay==null) {
				if (self.lastTrigger==button) {
					self.removeOverlay(isAnimated);
					return;
				}
			}
			else {
				self.removeOverlay(isAnimated);
			}
		}

		if (reparent) {
			view = self.getElementView(button);
			if (view) {
				view.appendChild(overlay);
			}
		}

		if (query) {
			//self.setElementAnimation(overlay, null);
			//overlay.style.animation = animation;
			self.enableMediaQuery(query);
			
			var display = overlay && overlay.style.display;
			
			if (overlay && display=="" || display=="none") {
				overlay.style.display = "block";
				//self.setViewOptions(overlay);
			}

			// add animation defined in event target style declaration
			if (animation && self.supportAnimations) {
				self.fadeIn(overlay, false, animation);
			}
		}
		else if (id) {

			display = window.getComputedStyle(overlay).getPropertyValue("display");

			if (display=="" || display=="none") {
				overlay.style.display = "block";
			}

			// add animation defined in event target style declaration
			if (animation && self.supportAnimations) {
				self.fadeIn(overlay, false, animation);
			}
		}

		// do not set x or y position if centering
		var horizontal = self.prefix + "center-horizontally";
		var vertical = self.prefix + "center-vertically";
		var style = overlay.style;
		var transform = [];

		centerHorizontally = self.getIsStyleDefined(id, horizontal) ? self.getViewPreferenceBoolean(overlay, horizontal) : false;
		centerVertically = self.getIsStyleDefined(id, vertical) ? self.getViewPreferenceBoolean(overlay, vertical) : false;
		anchorLeft = self.getIsStyleDefined(id, "left");
		anchorRight = self.getIsStyleDefined(id, "right");
		anchorTop = self.getIsStyleDefined(id, "top");
		anchorBottom = self.getIsStyleDefined(id, "bottom");

		
		if (self.viewsDictionary[overlay.id] && self.viewsDictionary[overlay.id].styleDeclaration) {
			style = self.viewsDictionary[overlay.id].styleDeclaration.style;
		}
		
		if (centerHorizontally) {
			style.left = "50%";
			style.transformOrigin = "0 0";
			transform.push("translateX(-50%)");
		}
		else if (anchorRight && anchorLeft) {
			style.left = x + "px";
		}
		else if (anchorRight) {
			//style.right = x + "px";
		}
		else {
			style.left = x + "px";
		}
		
		if (centerVertically) {
			style.top = "50%";
			transform.push("translateY(-50%)");
			style.transformOrigin = "0 0";
		}
		else if (anchorTop && anchorBottom) {
			style.top = y + "px";
		}
		else if (anchorBottom) {
			//style.bottom = y + "px";
		}
		else {
			style.top = y + "px";
		}

		if (transform.length) {
			style.transform = transform.join(" ");
		}

		self.currentOverlay = overlay;
		self.lastTrigger = button;
	}

	self.goBack = function() {
		if (self.currentOverlay) {
			self.removeOverlay();
		}
		else if (self.lastView) {
			self.goToView(self.lastView.id);
		}
	}

	self.removeOverlay = function(animate) {
		var overlay = self.currentOverlay;
		animate = animate===false ? false : true;

		if (overlay) {
			var style = overlay.style;
			
			if (style.animation && self.supportAnimations && animate) {
				self.reverseAnimation(overlay, true);

				var duration = self.getAnimationDuration(style.animation, true);
		
				setTimeout(function() {
					self.setElementAnimation(overlay, null);
					self.hideOverlay(overlay);
					self.currentOverlay = null;
				}, duration);
			}
			else {
				self.setElementAnimation(overlay, null);
				self.hideOverlay(overlay);
				self.currentOverlay = null;
			}
		}
	}

	/**
	 * Reverse the animation and hide after
	 * @param {Object} target element with animation
	 * @param {Boolean} hide hide after animation ends
	 */
	self.reverseAnimation = function(target, hide) {
		var lastAnimation = null;
		var style = target.style;

		style.animationPlayState = "paused";
		lastAnimation = style.animation;
		style.animation = null;
		style.animationPlayState = "paused";

		if (hide) {
			//target.addEventListener("animationend", self.animationEndHideHandler);
	
			var duration = self.getAnimationDuration(lastAnimation, true);
			var isOverlay = self.isOverlay(target);
	
			setTimeout(function() {
				self.setElementAnimation(target, null);

				if (isOverlay) {
					self.hideOverlay(target);
				}
				else {
					self.hideView(target);
				}
			}, duration);
		}

		setTimeout(function() {
			style.animation = lastAnimation;
			style.animationPlayState = "paused";
			style.animationDirection = "reverse";
			style.animationPlayState = "running";
		}, 30);
	}

	self.animationEndHandler = function(event) {
		var target = event.currentTarget;
		self.dispatchEvent(new Event(event.type));
	}

	self.isOverlay = function(view) {
		var result = view ? self.getViewPreferenceBoolean(view, self.prefix + "is-overlay") : false;

		return result;
	}

	self.animationEndHideHandler = function(event) {
		var target = event.currentTarget;
		self.setViewVariables(null, target);
		self.hideView(target);
		target.removeEventListener("animationend", self.animationEndHideHandler);
	}

	self.animationEndShowHandler = function(event) {
		var target = event.currentTarget;
		target.removeEventListener("animationend", self.animationEndShowHandler);
	}

	self.setViewOptions = function(view) {

		if (view) {
			self.minimumScale = self.getViewPreferenceValue(view, self.prefix + "minimum-scale");
			self.maximumScale = self.getViewPreferenceValue(view, self.prefix + "maximum-scale");
			self.scaleViewsToFit = self.getViewPreferenceBoolean(view, self.prefix + "scale-to-fit");
			self.scaleToFitType = self.getViewPreferenceValue(view, self.prefix + "scale-to-fit-type");
			self.scaleToFitOnDoubleClick = self.getViewPreferenceBoolean(view, self.prefix + "scale-on-double-click");
			self.actualSizeOnDoubleClick = self.getViewPreferenceBoolean(view, self.prefix + "actual-size-on-double-click");
			self.scaleViewsOnResize = self.getViewPreferenceBoolean(view, self.prefix + "scale-on-resize");
			self.enableScaleUp = self.getViewPreferenceBoolean(view, self.prefix + "enable-scale-up");
			self.centerHorizontally = self.getViewPreferenceBoolean(view, self.prefix + "center-horizontally");
			self.centerVertically = self.getViewPreferenceBoolean(view, self.prefix + "center-vertically");
			self.navigationOnKeypress = self.getViewPreferenceBoolean(view, self.prefix + "navigate-on-keypress");
			self.showViewName = self.getViewPreferenceBoolean(view, self.prefix + "show-view-name");
			self.refreshPageForChanges = self.getViewPreferenceBoolean(view, self.prefix + "refresh-for-changes");
			self.refreshPageForChangesInterval = self.getViewPreferenceValue(view, self.prefix + "refresh-interval");
			self.showNavigationControls = self.getViewPreferenceBoolean(view, self.prefix + "show-navigation-controls");
			self.scaleViewSlider = self.getViewPreferenceBoolean(view, self.prefix + "show-scale-controls");
			self.enableDeepLinking = self.getViewPreferenceBoolean(view, self.prefix + "enable-deep-linking");
			self.singlePageApplication = self.getViewPreferenceBoolean(view, self.prefix + "application");
			self.showByMediaQuery = self.getViewPreferenceBoolean(view, self.prefix + "show-by-media-query");
			self.showUpdateNotification = document.cookie!="" ? document.cookie.indexOf(self.pageRefreshedName)!=-1 : false;
			self.imageComparisonDuration = self.getViewPreferenceValue(view, self.prefix + "image-comparison-duration");
			self.supportAnimations = self.getViewPreferenceBoolean(view, self.prefix + "enable-animations", true);

			if (self.scaleViewsToFit) {
				var newScaleValue = self.scaleViewToFit(view);
				
				if (newScaleValue<0) {
					setTimeout(self.scaleViewToFit, 500, view);
				}
			}
			else {
				self.viewScale = self.getViewScaleValue(view);
				self.viewToFitWidthScale = self.getViewFitToViewportWidthScale(view, self.enableScaleUp)
				self.viewToFitHeightScale = self.getViewFitToViewportScale(view, self.enableScaleUp);
				self.updateSliderValue(self.viewScale);
			}

			if (self.imageComparisonDuration!=null) {
				// todo
			}

			if (self.refreshPageForChangesInterval!=null) {
				self.refreshDuration = Number(self.refreshPageForChangesInterval);
			}
		}
	}

	self.previousView = function(event) {
		var rules = self.getStylesheetRules();
		var view = self.getVisibleView()
		var index = view ? self.getViewIndex(view) : -1;
		var prevQueryIndex = index!=-1 ? index-1 : self.currentQuery.index-1;
		var queryIndex = 0;
		var numberOfRules = rules!=null ? rules.length : 0;

		if (event) {
			event.stopImmediatePropagation();
		}

		if (prevQueryIndex<0) {
			return;
		}

		// loop through rules and hide media queries except selected
		for (var i=0;i<numberOfRules;i++) {
			var rule = rules[i];
			
			if (rule.media!=null) {

				if (queryIndex==prevQueryIndex) {
					self.currentQuery.mediaText = rule.conditionText;
					self.currentQuery.index = prevQueryIndex;
					self.currentQuery.rule = rule;
					self.enableMediaQuery(rule);
					self.updateViewLabel();
					self.updateURL();
					self.dispatchViewChange();
				}
				else {
					self.disableMediaQuery(rule);
				}

				queryIndex++;
			}
		}
	}

	self.nextView = function(event) {
		var rules = self.getStylesheetRules();
		var view = self.getVisibleView();
		var index = view ? self.getViewIndex(view) : -1;
		var nextQueryIndex = index!=-1 ? index+1 : self.currentQuery.index+1;
		var queryIndex = 0;
		var numberOfRules = rules!=null ? rules.length : 0;
		var numberOfMediaQueries = self.getNumberOfMediaRules();

		if (event) {
			event.stopImmediatePropagation();
		}

		if (nextQueryIndex>=numberOfMediaQueries) {
			return;
		}

		// loop through rules and hide media queries except selected
		for (var i=0;i<numberOfRules;i++) {
			var rule = rules[i];
			
			if (rule.media!=null) {

				if (queryIndex==nextQueryIndex) {
					self.currentQuery.mediaText = rule.conditionText;
					self.currentQuery.index = nextQueryIndex;
					self.currentQuery.rule = rule;
					self.enableMediaQuery(rule);
					self.updateViewLabel();
					self.updateURL();
					self.dispatchViewChange();
				}
				else {
					self.disableMediaQuery(rule);
				}

				queryIndex++;
			}
		}
	}

	/**
	 * Enables a view via media query
	 */
	self.enableMediaQuery = function(rule) {

		try {
			rule.media.mediaText = self.inclusionQuery;
		}
		catch(error) {
			//self.log(error);
			rule.conditionText = self.inclusionQuery;
		}
	}

	self.disableMediaQuery = function(rule) {

		try {
			rule.media.mediaText = self.exclusionQuery;
		}
		catch(error) {
			rule.conditionText = self.exclusionQuery;
		}
	}

	self.dispatchViewChange = function() {
		try {
			var event = new Event(self.NAVIGATION_CHANGE);
			window.dispatchEvent(event);
		}
		catch (error) {
			// In IE 11: Object doesn't support this action
		}
	}

	self.getNumberOfMediaRules = function() {
		var rules = self.getStylesheetRules();
		var numberOfRules = rules ? rules.length : 0;
		var numberOfQueries = 0;

		for (var i=0;i<numberOfRules;i++) {
			if (rules[i].media!=null) { numberOfQueries++; }
		}
		
		return numberOfQueries;
	}

	/////////////////////////////////////////
	// VIEW SCALE 
	/////////////////////////////////////////

	self.sliderChangeHandler = function(event) {
		var value = self.getShortNumber(event.currentTarget.value/100);
		var view = self.getVisibleView();
		self.setViewScaleValue(view, false, value, true);
	}

	self.updateSliderValue = function(scale) {
		var slider = document.getElementById(self.viewScaleSliderId);
		var tooltip = parseInt(scale * 100 + "") + "%";
		var inputType;
		var inputValue;
		
		if (slider) {
			inputValue = self.getShortNumber(scale * 100);
			if (inputValue!=slider["value"]) {
				slider["value"] = inputValue;
			}
			inputType = slider.getAttributeNS(null, "type");

			if (inputType!="range") {
				// input range is not supported
				slider.style.display = "none";
			}

			self.setTooltip(slider, tooltip);
		}
	}

	self.viewChangeHandler = function(event) {
		var view = self.getVisibleView();
		var matrix = view ? getComputedStyle(view).transform : null;
		
		if (matrix) {
			self.viewScale = self.getViewScaleValue(view);
			
			var scaleNeededToFit = self.getViewFitToViewportScale(view);
			var isViewLargerThanViewport = scaleNeededToFit<1;
			
			// scale large view to fit if scale to fit is enabled
			if (self.scaleViewsToFit) {
				self.scaleViewToFit(view);
			}
			else {
				self.updateSliderValue(self.viewScale);
			}
		}
	}

	self.getViewScaleValue = function(view) {
		var matrix = getComputedStyle(view).transform;

		if (matrix) {
			var matrixArray = matrix.replace("matrix(", "").split(",");
			var scaleX = parseFloat(matrixArray[0]);
			var scaleY = parseFloat(matrixArray[3]);
			var scale = Math.min(scaleX, scaleY);
		}

		return scale;
	}

	/**
	 * Scales view to scale. 
	 * @param {Object} view view to scale. views are in views array
	 * @param {Boolean} scaleToFit set to true to scale to fit. set false to use desired scale value
	 * @param {Number} desiredScale scale to define. not used if scale to fit is false
	 * @param {Boolean} isSliderChange indicates if slider is callee
	 */
	self.setViewScaleValue = function(view, scaleToFit, desiredScale, isSliderChange) {
		var enableScaleUp = self.enableScaleUp;
		var scaleToFitType = self.scaleToFitType;
		var minimumScale = self.minimumScale;
		var maximumScale = self.maximumScale;
		var hasMinimumScale = !isNaN(minimumScale) && minimumScale!="";
		var hasMaximumScale = !isNaN(maximumScale) && maximumScale!="";
		var scaleNeededToFit = self.getViewFitToViewportScale(view, enableScaleUp);
		var scaleNeededToFitWidth = self.getViewFitToViewportWidthScale(view, enableScaleUp);
		var scaleNeededToFitHeight = self.getViewFitToViewportHeightScale(view, enableScaleUp);
		var scaleToFitFull = self.getViewFitToViewportScale(view, true);
		var scaleToFitFullWidth = self.getViewFitToViewportWidthScale(view, true);
		var scaleToFitFullHeight = self.getViewFitToViewportHeightScale(view, true);
		var scaleToWidth = scaleToFitType=="width";
		var scaleToHeight = scaleToFitType=="height";
		var shrunkToFit = false;
		var topPosition = null;
		var leftPosition = null;
		var translateY = null;
		var translateX = null;
		var transformValue = "";
		var canCenterVertically = true;
		var canCenterHorizontally = true;
		var style = view.style;

		if (view && self.viewsDictionary[view.id] && self.viewsDictionary[view.id].styleDeclaration) {
			style = self.viewsDictionary[view.id].styleDeclaration.style;
		}

		if (scaleToFit && isSliderChange!=true) {
			if (scaleToFitType=="fit" || scaleToFitType=="") {
				desiredScale = scaleNeededToFit;
			}
			else if (scaleToFitType=="width") {
				desiredScale = scaleNeededToFitWidth;
			}
			else if (scaleToFitType=="height") {
				desiredScale = scaleNeededToFitHeight;
			}
		}
		else {
			if (isNaN(desiredScale)) {
				desiredScale = 1;
			}
		}

		self.updateSliderValue(desiredScale);
		
		// scale to fit width
		if (scaleToWidth && scaleToHeight==false) {
			canCenterVertically = scaleNeededToFitHeight>=scaleNeededToFitWidth;
			canCenterHorizontally = scaleNeededToFitWidth>=1 && enableScaleUp==false;

			if (isSliderChange) {
				canCenterHorizontally = desiredScale<scaleToFitFullWidth;
			}
			else if (scaleToFit) {
				desiredScale = scaleNeededToFitWidth;
			}

			if (hasMinimumScale) {
				desiredScale = Math.max(desiredScale, Number(minimumScale));
			}

			if (hasMaximumScale) {
				desiredScale = Math.min(desiredScale, Number(maximumScale));
			}

			desiredScale = self.getShortNumber(desiredScale);

			canCenterHorizontally = self.canCenterHorizontally(view, "width", enableScaleUp, desiredScale, minimumScale, maximumScale);
			canCenterVertically = self.canCenterVertically(view, "width", enableScaleUp, desiredScale, minimumScale, maximumScale);

			if (desiredScale>1 && (enableScaleUp || isSliderChange)) {
				transformValue = "scale(" + desiredScale + ")";
			}
			else if (desiredScale>=1 && enableScaleUp==false) {
				transformValue = "scale(" + 1 + ")";
			}
			else {
				transformValue = "scale(" + desiredScale + ")";
			}

			if (self.centerVertically) {
				if (canCenterVertically) {
					translateY = "-50%";
					topPosition = "50%";
				}
				else {
					translateY = "0";
					topPosition = "0";
				}
				
				if (style.top != topPosition) {
					style.top = topPosition + "";
				}

				if (canCenterVertically) {
					transformValue += " translateY(" + translateY+ ")";
				}
			}

			if (self.centerHorizontally) {
				if (canCenterHorizontally) {
					translateX = "-50%";
					leftPosition = "50%";
				}
				else {
					translateX = "0";
					leftPosition = "0";
				}

				if (style.left != leftPosition) {
					style.left = leftPosition + "";
				}

				if (canCenterHorizontally) {
					transformValue += " translateX(" + translateX+ ")";
				}
			}

			style.transformOrigin = "0 0";
			style.transform = transformValue;

			self.viewScale = desiredScale;
			self.viewToFitWidthScale = scaleNeededToFitWidth;
			self.viewToFitHeightScale = scaleNeededToFitHeight;
			self.viewLeft = leftPosition;
			self.viewTop = topPosition;

			return desiredScale;
		}

		// scale to fit height
		if (scaleToHeight && scaleToWidth==false) {
			//canCenterVertically = scaleNeededToFitHeight>=scaleNeededToFitWidth;
			//canCenterHorizontally = scaleNeededToFitHeight<=scaleNeededToFitWidth && enableScaleUp==false;
			canCenterVertically = scaleNeededToFitHeight>=scaleNeededToFitWidth;
			canCenterHorizontally = scaleNeededToFitWidth>=1 && enableScaleUp==false;
			
			if (isSliderChange) {
				canCenterHorizontally = desiredScale<scaleToFitFullHeight;
			}
			else if (scaleToFit) {
				desiredScale = scaleNeededToFitHeight;
			}

			if (hasMinimumScale) {
				desiredScale = Math.max(desiredScale, Number(minimumScale));
			}

			if (hasMaximumScale) {
				desiredScale = Math.min(desiredScale, Number(maximumScale));
				//canCenterVertically = desiredScale>=scaleNeededToFitHeight && enableScaleUp==false;
			}

			desiredScale = self.getShortNumber(desiredScale);

			canCenterHorizontally = self.canCenterHorizontally(view, "height", enableScaleUp, desiredScale, minimumScale, maximumScale);
			canCenterVertically = self.canCenterVertically(view, "height", enableScaleUp, desiredScale, minimumScale, maximumScale);

			if (desiredScale>1 && (enableScaleUp || isSliderChange)) {
				transformValue = "scale(" + desiredScale + ")";
			}
			else if (desiredScale>=1 && enableScaleUp==false) {
				transformValue = "scale(" + 1 + ")";
			}
			else {
				transformValue = "scale(" + desiredScale + ")";
			}

			if (self.centerHorizontally) {
				if (canCenterHorizontally) {
					translateX = "-50%";
					leftPosition = "50%";
				}
				else {
					translateX = "0";
					leftPosition = "0";
				}

				if (style.left != leftPosition) {
					style.left = leftPosition + "";
				}

				if (canCenterHorizontally) {
					transformValue += " translateX(" + translateX+ ")";
				}
			}

			if (self.centerVertically) {
				if (canCenterVertically) {
					translateY = "-50%";
					topPosition = "50%";
				}
				else {
					translateY = "0";
					topPosition = "0";
				}
				
				if (style.top != topPosition) {
					style.top = topPosition + "";
				}

				if (canCenterVertically) {
					transformValue += " translateY(" + translateY+ ")";
				}
			}

			style.transformOrigin = "0 0";
			style.transform = transformValue;

			self.viewScale = desiredScale;
			self.viewToFitWidthScale = scaleNeededToFitWidth;
			self.viewToFitHeightScale = scaleNeededToFitHeight;
			self.viewLeft = leftPosition;
			self.viewTop = topPosition;

			return scaleNeededToFitHeight;
		}

		if (scaleToFitType=="fit") {
			//canCenterVertically = scaleNeededToFitHeight>=scaleNeededToFitWidth;
			//canCenterHorizontally = scaleNeededToFitWidth>=scaleNeededToFitHeight;
			canCenterVertically = scaleNeededToFitHeight>=scaleNeededToFit;
			canCenterHorizontally = scaleNeededToFitWidth>=scaleNeededToFit;

			if (hasMinimumScale) {
				desiredScale = Math.max(desiredScale, Number(minimumScale));
			}

			desiredScale = self.getShortNumber(desiredScale);

			if (isSliderChange || scaleToFit==false) {
				canCenterVertically = scaleToFitFullHeight>=desiredScale;
				canCenterHorizontally = desiredScale<scaleToFitFullWidth;
			}
			else if (scaleToFit) {
				desiredScale = scaleNeededToFit;
			}

			transformValue = "scale(" + desiredScale + ")";

			//canCenterHorizontally = self.canCenterHorizontally(view, "fit", false, desiredScale);
			//canCenterVertically = self.canCenterVertically(view, "fit", false, desiredScale);
			
			if (self.centerVertically) {
				if (canCenterVertically) {
					translateY = "-50%";
					topPosition = "50%";
				}
				else {
					translateY = "0";
					topPosition = "0";
				}
				
				if (style.top != topPosition) {
					style.top = topPosition + "";
				}

				if (canCenterVertically) {
					transformValue += " translateY(" + translateY+ ")";
				}
			}

			if (self.centerHorizontally) {
				if (canCenterHorizontally) {
					translateX = "-50%";
					leftPosition = "50%";
				}
				else {
					translateX = "0";
					leftPosition = "0";
				}

				if (style.left != leftPosition) {
					style.left = leftPosition + "";
				}

				if (canCenterHorizontally) {
					transformValue += " translateX(" + translateX+ ")";
				}
			}

			style.transformOrigin = "0 0";
			style.transform = transformValue;

			self.viewScale = desiredScale;
			self.viewToFitWidthScale = scaleNeededToFitWidth;
			self.viewToFitHeightScale = scaleNeededToFitHeight;
			self.viewLeft = leftPosition;
			self.viewTop = topPosition;

			self.updateSliderValue(desiredScale);
			
			return desiredScale;
		}

		if (scaleToFitType=="default" || scaleToFitType=="") {
			desiredScale = 1;

			if (hasMinimumScale) {
				desiredScale = Math.max(desiredScale, Number(minimumScale));
			}
			if (hasMaximumScale) {
				desiredScale = Math.min(desiredScale, Number(maximumScale));
			}

			canCenterHorizontally = self.canCenterHorizontally(view, "none", false, desiredScale, minimumScale, maximumScale);
			canCenterVertically = self.canCenterVertically(view, "none", false, desiredScale, minimumScale, maximumScale);

			if (self.centerVertically) {
				if (canCenterVertically) {
					translateY = "-50%";
					topPosition = "50%";
				}
				else {
					translateY = "0";
					topPosition = "0";
				}
				
				if (style.top != topPosition) {
					style.top = topPosition + "";
				}

				if (canCenterVertically) {
					transformValue += " translateY(" + translateY+ ")";
				}
			}

			if (self.centerHorizontally) {
				if (canCenterHorizontally) {
					translateX = "-50%";
					leftPosition = "50%";
				}
				else {
					translateX = "0";
					leftPosition = "0";
				}

				if (style.left != leftPosition) {
					style.left = leftPosition + "";
				}

				if (canCenterHorizontally) {
					transformValue += " translateX(" + translateX+ ")";
				}
				else {
					transformValue += " translateX(" + 0 + ")";
				}
			}

			style.transformOrigin = "0 0";
			style.transform = transformValue;


			self.viewScale = desiredScale;
			self.viewToFitWidthScale = scaleNeededToFitWidth;
			self.viewToFitHeightScale = scaleNeededToFitHeight;
			self.viewLeft = leftPosition;
			self.viewTop = topPosition;

			self.updateSliderValue(desiredScale);
			
			return desiredScale;
		}
	}

	/**
	 * Returns true if view can be centered horizontally
	 * @param {HTMLElement} view view
	 * @param {String} type type of scaling - width, height, all, none
	 * @param {Boolean} scaleUp if scale up enabled 
	 * @param {Number} scale target scale value 
	 */
	self.canCenterHorizontally = function(view, type, scaleUp, scale, minimumScale, maximumScale) {
		var scaleNeededToFit = self.getViewFitToViewportScale(view, scaleUp);
		var scaleNeededToFitHeight = self.getViewFitToViewportHeightScale(view, scaleUp);
		var scaleNeededToFitWidth = self.getViewFitToViewportWidthScale(view, scaleUp);
		var canCenter = false;
		var minScale;

		type = type==null ? "none" : type;
		scale = scale==null ? scale : scaleNeededToFitWidth;
		scaleUp = scaleUp == null ? false : scaleUp;

		if (type=="width") {
	
			if (scaleUp && maximumScale==null) {
				canCenter = false;
			}
			else if (scaleNeededToFitWidth>=1) {
				canCenter = true;
			}
		}
		else if (type=="height") {
			minScale = Math.min(1, scaleNeededToFitHeight);
			if (minimumScale!="" && maximumScale!="") {
				minScale = Math.max(minimumScale, Math.min(maximumScale, scaleNeededToFitHeight));
			}
			else {
				if (minimumScale!="") {
					minScale = Math.max(minimumScale, scaleNeededToFitHeight);
				}
				if (maximumScale!="") {
					minScale = Math.max(minimumScale, Math.min(maximumScale, scaleNeededToFitHeight));
				}
			}
	
			if (scaleUp && maximumScale=="") {
				canCenter = false;
			}
			else if (scaleNeededToFitWidth>=minScale) {
				canCenter = true;
			}
		}
		else if (type=="fit") {
			canCenter = scaleNeededToFitWidth>=scaleNeededToFit;
		}
		else {
			if (scaleUp) {
				canCenter = false;
			}
			else if (scaleNeededToFitWidth>=1) {
				canCenter = true;
			}
		}

		self.horizontalScrollbarsNeeded = canCenter;
		
		return canCenter;
	}

	/**
	 * Returns true if view can be centered horizontally
	 * @param {HTMLElement} view view to scale
	 * @param {String} type type of scaling
	 * @param {Boolean} scaleUp if scale up enabled 
	 * @param {Number} scale target scale value 
	 */
	self.canCenterVertically = function(view, type, scaleUp, scale, minimumScale, maximumScale) {
		var scaleNeededToFit = self.getViewFitToViewportScale(view, scaleUp);
		var scaleNeededToFitWidth = self.getViewFitToViewportWidthScale(view, scaleUp);
		var scaleNeededToFitHeight = self.getViewFitToViewportHeightScale(view, scaleUp);
		var canCenter = false;
		var minScale;

		type = type==null ? "none" : type;
		scale = scale==null ? 1 : scale;
		scaleUp = scaleUp == null ? false : scaleUp;
	
		if (type=="width") {
			canCenter = scaleNeededToFitHeight>=scaleNeededToFitWidth;
		}
		else if (type=="height") {
			minScale = Math.max(minimumScale, Math.min(maximumScale, scaleNeededToFit));
			canCenter = scaleNeededToFitHeight>=minScale;
		}
		else if (type=="fit") {
			canCenter = scaleNeededToFitHeight>=scaleNeededToFit;
		}
		else {
			if (scaleUp) {
				canCenter = false;
			}
			else if (scaleNeededToFitHeight>=1) {
				canCenter = true;
			}
		}

		self.verticalScrollbarsNeeded = canCenter;
		
		return canCenter;
	}

	self.getViewFitToViewportScale = function(view, scaleUp) {
		var enableScaleUp = scaleUp;
		var availableWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		var availableHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var elementWidth = parseFloat(getComputedStyle(view, "style").width);
		var elementHeight = parseFloat(getComputedStyle(view, "style").height);
		var newScale = 1;

		// if element is not added to the document computed values are NaN
		if (isNaN(elementWidth) || isNaN(elementHeight)) {
			return newScale;
		}

		availableWidth -= self.horizontalPadding;
		availableHeight -= self.verticalPadding;

		if (enableScaleUp) {
			newScale = Math.min(availableHeight/elementHeight, availableWidth/elementWidth);
		}
		else if (elementWidth > availableWidth || elementHeight > availableHeight) {
			newScale = Math.min(availableHeight/elementHeight, availableWidth/elementWidth);
		}
		
		return newScale;
	}

	self.getViewFitToViewportWidthScale = function(view, scaleUp) {
		// need to get browser viewport width when element
		var isParentWindow = view && view.parentNode && view.parentNode===document.body;
		var enableScaleUp = scaleUp;
		var availableWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		var elementWidth = parseFloat(getComputedStyle(view, "style").width);
		var newScale = 1;

		// if element is not added to the document computed values are NaN
		if (isNaN(elementWidth)) {
			return newScale;
		}

		availableWidth -= self.horizontalPadding;

		if (enableScaleUp) {
			newScale = availableWidth/elementWidth;
		}
		else if (elementWidth > availableWidth) {
			newScale = availableWidth/elementWidth;
		}
		
		return newScale;
	}

	self.getViewFitToViewportHeightScale = function(view, scaleUp) {
		var enableScaleUp = scaleUp;
		var availableHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
		var elementHeight = parseFloat(getComputedStyle(view, "style").height);
		var newScale = 1;

		// if element is not added to the document computed values are NaN
		if (isNaN(elementHeight)) {
			return newScale;
		}

		availableHeight -= self.verticalPadding;

		if (enableScaleUp) {
			newScale = availableHeight/elementHeight;
		}
		else if (elementHeight > availableHeight) {
			newScale = availableHeight/elementHeight;
		}
		
		return newScale;
	}

	self.keypressHandler = function(event) {
		var rightKey = 39;
		var leftKey = 37;
		
		// listen for both events 
		if (event.type=="keypress") {
			window.removeEventListener("keyup", self.keypressHandler);
		}
		else {
			window.removeEventListener("keypress", self.keypressHandler);
		}
		
		if (self.showNavigationControls) {
			if (self.navigationOnKeypress) {
				if (event.keyCode==rightKey) {
					self.nextView();
				}
				if (event.keyCode==leftKey) {
					self.previousView();
				}
			}
		}
		else if (self.navigationOnKeypress) {
			if (event.keyCode==rightKey) {
				self.nextView();
			}
			if (event.keyCode==leftKey) {
				self.previousView();
			}
		}
	}

	///////////////////////////////////
	// GENERAL FUNCTIONS
	///////////////////////////////////

	self.getViewById = function(id) {
		id = id ? id.replace("#", "") : "";
		var view = self.viewIds.indexOf(id)!=-1 && self.getElement(id);
		return view;
	}

	self.getViewIds = function() {
		var viewIds = self.getViewPreferenceValue(document.body, self.prefix + "view-ids");
		var viewId = null;

		viewIds = viewIds!=null && viewIds!="" ? viewIds.split(",") : [];

		if (viewIds.length==0) {
			viewId = self.getViewPreferenceValue(document.body, self.prefix + "view-id");
			viewIds = viewId ? [viewId] : [];
		}

		return viewIds;
	}

	self.getInitialViewId = function() {
		var viewId = self.getViewPreferenceValue(document.body, self.prefix + "view-id");
		return viewId;
	}

	self.getApplicationStylesheet = function() {
		var stylesheetId = self.getViewPreferenceValue(document.body, self.prefix + "stylesheet-id");
		self.applicationStylesheet = document.getElementById("applicationStylesheet");
		return self.applicationStylesheet.sheet;
	}

	self.getVisibleView = function() {
		var viewIds = self.getViewIds();
		
		for (var i=0;i<viewIds.length;i++) {
			var viewId = viewIds[i].replace(/[\#?\.?](.*)/, "$" + "1");
			var view = self.getElement(viewId);
			var postName = "_Class";

			if (view==null && viewId && viewId.lastIndexOf(postName)!=-1) {
				view = self.getElement(viewId.replace(postName, ""));
			}
			
			if (view) {
				var display = getComputedStyle(view).display;
		
				if (display=="block" || display=="flex") {
					return view;
				}
			}
		}

		return null;
	}

	self.getVisibleViews = function() {
		var viewIds = self.getViewIds();
		var views = [];
		
		for (var i=0;i<viewIds.length;i++) {
			var viewId = viewIds[i].replace(/[\#?\.?](.*)/, "$" + "1");
			var view = self.getElement(viewId);
			var postName = "_Class";

			if (view==null && viewId && viewId.lastIndexOf(postName)!=-1) {
				view = self.getElement(viewId.replace(postName, ""));
			}
			
			if (view) {
				var display = getComputedStyle(view).display;
				
				if (display=="none") {
					continue;
				}

				if (display=="block" || display=="flex") {
					views.push(view);
				}
			}
		}

		return views;
	}

	self.getStateNameByViewId = function(id) {
		var state = self.viewsDictionary[id];
		return state && state.stateName;
	}

	self.getMatchingViews = function(ids) {
		var views = self.addedViews.slice(0);
		var matchingViews = [];

		if (self.showByMediaQuery) {
			for (let index = 0; index < views.length; index++) {
				var viewId = views[index];
				var state = self.viewsDictionary[viewId];
				var rule = state && state.rule; 
				var matchResults = window.matchMedia(rule.conditionText);
				var view = self.views[viewId];
				
				if (matchResults.matches) {
					if (ids==true) {
						matchingViews.push(viewId);
					}
					else {
						matchingViews.push(view);
					}
				}
			}
		}

		return matchingViews;
	}

	self.ruleMatchesQuery = function(rule) {
		var result = window.matchMedia(rule.conditionText);
		return result.matches;
	}

	self.getViewsByStateName = function(stateName, matchQuery) {
		var views = self.addedViews.slice(0);
		var matchingViews = [];

		if (self.showByMediaQuery) {

			// find state name
			for (let index = 0; index < views.length; index++) {
				var viewId = views[index];
				var state = self.viewsDictionary[viewId];
				var rule = state.rule;
				var mediaRule = state.mediaRule;
				var view = self.views[viewId];
				var viewStateName = self.getStyleRuleValue(mediaRule, self.STATE_NAME, state);
				var stateFoundAtt = view.getAttribute(self.STATE_NAME)==state;
				var matchesResults = false;
				
				if (viewStateName==stateName) {
					if (matchQuery) {
						matchesResults = self.ruleMatchesQuery(rule);

						if (matchesResults) {
							matchingViews.push(view);
						}
					}
					else {
						matchingViews.push(view);
					}
				}
			}
		}

		return matchingViews;
	}

	self.getInitialView = function() {
		var viewId = self.getInitialViewId();
		viewId = viewId.replace(/[\#?\.?](.*)/, "$" + "1");
		var view = self.getElement(viewId);
		var postName = "_Class";

		if (view==null && viewId && viewId.lastIndexOf(postName)!=-1) {
			view = self.getElement(viewId.replace(postName, ""));
		}

		return view;
	}

	self.getViewIndex = function(view) {
		var viewIds = self.getViewIds();
		var id = view ? view.id : null;
		var index = id && viewIds ? viewIds.indexOf(id) : -1;

		return index;
	}

	self.syncronizeViewToURL = function() {
		var fragment = self.getHashFragment();

		if (self.showByMediaQuery) {
			var stateName = fragment;
			
			if (stateName==null || stateName=="") {
				var initialView = self.getInitialView();
				stateName = initialView ? self.getStateNameByViewId(initialView.id) : null;
			}
			
			self.showMediaQueryViewsByState(stateName);
			return;
		}

		var view = self.getViewById(fragment);
		var index = view ? self.getViewIndex(view) : 0;
		if (index==-1) index = 0;
		var currentView = self.hideViews(index);

		if (self.supportsPopState && currentView) {

			if (fragment==null) {
				window.history.replaceState({name:currentView.id}, null, "#"+ currentView.id);
			}
			else {
				window.history.pushState({name:currentView.id}, null, "#"+ currentView.id);
			}
		}
		
		self.setViewVariables(view);
		return view;
	}

	/**
	 * Set the currentView or currentOverlay properties and set the lastView or lastOverlay properties
	 */
	self.setViewVariables = function(view, overlay, parentView) {
		if (view) {
			if (self.currentView) {
				self.lastView = self.currentView;
			}
			self.currentView = view;
		}

		if (overlay) {
			if (self.currentOverlay) {
				self.lastOverlay = self.currentOverlay;
			}
			self.currentOverlay = overlay;
		}
	}

	self.getViewPreferenceBoolean = function(view, property, altValue) {
		var computedStyle = window.getComputedStyle(view);
		var value = computedStyle.getPropertyValue(property);
		var type = typeof value;
		
		if (value=="true" || (type=="string" && value.indexOf("true")!=-1)) {
			return true;
		}
		else if (value=="" && arguments.length==3) {
			return altValue;
		}

		return false;
	}

	self.getViewPreferenceValue = function(view, property, defaultValue) {
		var value = window.getComputedStyle(view).getPropertyValue(property);

		if (value===undefined) {
			return defaultValue;
		}
		
		value = value.replace(/^[\s\"]*/, "");
		value = value.replace(/[\s\"]*$/, "");
		value = value.replace(/^[\s"]*(.*?)[\s"]*$/, function (match, capture) { 
			return capture;
		});

		return value;
	}

	self.getStyleRuleValue = function(cssRule, property) {
		var value = cssRule ? cssRule.style.getPropertyValue(property) : null;

		if (value===undefined) {
			return null;
		}
		
		value = value.replace(/^[\s\"]*/, "");
		value = value.replace(/[\s\"]*$/, "");
		value = value.replace(/^[\s"]*(.*?)[\s"]*$/, function (match, capture) { 
			return capture;
		});

		return value;
	}

	/**
	 * Get the first defined value of property. Returns empty string if not defined
	 * @param {String} id id of element
	 * @param {String} property 
	 */
	self.getCSSPropertyValueForElement = function(id, property) {
		var styleSheets = document.styleSheets;
		var numOfStylesheets = styleSheets.length;
		var values = [];
		var selectorIDText = "#" + id;
		var selectorClassText = "." + id + "_Class";
		var value;

		for(var i=0;i<numOfStylesheets;i++) {
			var styleSheet = styleSheets[i];
			var cssRules = self.getStylesheetRules(styleSheet);
			var numOfCSSRules = cssRules.length;
			var cssRule;
			
			for (var j=0;j<numOfCSSRules;j++) {
				cssRule = cssRules[j];
				
				if (cssRule.media) {
					var mediaRules = cssRule.cssRules;
					var numOfMediaRules = mediaRules ? mediaRules.length : 0;
					
					for(var k=0;k<numOfMediaRules;k++) {
						var mediaRule = mediaRules[k];
						
						if (mediaRule.selectorText==selectorIDText || mediaRule.selectorText==selectorClassText) {
							
							if (mediaRule.style && mediaRule.style.getPropertyValue(property)!="") {
								value = mediaRule.style.getPropertyValue(property);
								values.push(value);
							}
						}
					}
				}
				else {

					if (cssRule.selectorText==selectorIDText || cssRule.selectorText==selectorClassText) {
						if (cssRule.style && cssRule.style.getPropertyValue(property)!="") {
							value = cssRule.style.getPropertyValue(property);
							values.push(value);
						}
					}
				}
			}
		}

		return values.pop();
	}

	self.getIsStyleDefined = function(id, property) {
		var value = self.getCSSPropertyValueForElement(id, property);
		return value!==undefined && value!="";
	}

	self.collectViews = function() {
		var viewIds = self.getViewIds();

		for (let index = 0; index < viewIds.length; index++) {
			const id = viewIds[index];
			const view = self.getElement(id);
			self.views[id] = view;
		}
		
		self.viewIds = viewIds;
	}

	self.collectOverlays = function() {
		var viewIds = self.getViewIds();
		var ids = [];

		for (let index = 0; index < viewIds.length; index++) {
			const id = viewIds[index];
			const view = self.getViewById(id);
			const isOverlay = view && self.isOverlay(view);
			
			if (isOverlay) {
				ids.push(id);
				self.overlays[id] = view;
			}
		}
		
		self.overlayIds = ids;
	}

	self.collectMediaQueries = function() {
		var viewIds = self.getViewIds();
		var styleSheet = self.getApplicationStylesheet();
		var cssRules = self.getStylesheetRules(styleSheet);
		var numOfCSSRules = cssRules ? cssRules.length : 0;
		var cssRule;
		var id = viewIds.length ? viewIds[0]: ""; // single view
		var selectorIDText = "#" + id;
		var selectorClassText = "." + id + "_Class";
		var viewsNotFound = viewIds.slice();
		var viewsFound = [];
		var selectorText = null;
		var property = self.prefix + "view-id";
		var stateName = self.prefix + "state";
		var stateValue;
		
		for (var j=0;j<numOfCSSRules;j++) {
			cssRule = cssRules[j];
			
			if (cssRule.media) {
				var mediaRules = cssRule.cssRules;
				var numOfMediaRules = mediaRules ? mediaRules.length : 0;
				var mediaViewInfoFound = false;
				var mediaId = null;
				
				for(var k=0;k<numOfMediaRules;k++) {
					var mediaRule = mediaRules[k];

					selectorText = mediaRule.selectorText;
					
					if (selectorText==".mediaViewInfo" && mediaViewInfoFound==false) {

						mediaId = self.getStyleRuleValue(mediaRule, property);
						stateValue = self.getStyleRuleValue(mediaRule, stateName);

						selectorIDText = "#" + mediaId;
						selectorClassText = "." + mediaId + "_Class";
						
						// prevent duplicates from load and domcontentloaded events
						if (self.addedViews.indexOf(mediaId)==-1) {
							self.addView(mediaId, cssRule, mediaRule, stateValue);
						}

						viewsFound.push(mediaId);

						if (viewsNotFound.indexOf(mediaId)!=-1) {
							viewsNotFound.splice(viewsNotFound.indexOf(mediaId));
						}

						mediaViewInfoFound = true;
					}

					if (selectorIDText==selectorText || selectorClassText==selectorText) {
						var styleObject = self.viewsDictionary[mediaId];
						if (styleObject) {
							styleObject.styleDeclaration = mediaRule;
						}
						break;
					}
				}
			}
			else {
				selectorText = cssRule.selectorText.replace(/[#|\s|*]?/g, "");

				if (viewIds.indexOf(selectorText)!=-1) {
					self.addView(selectorText, cssRule, null, stateValue);

					if (viewsNotFound.indexOf(selectorText)!=-1) {
						viewsNotFound.splice(viewsNotFound.indexOf(selectorText));
					}

					break;
				}
			}
		}

		if (viewsNotFound.length) {
			console.log("Could not find the following views:" + viewsNotFound.join(",") + "");
			console.log("Views found:" + viewsFound.join(",") + "");
		}
	}

	/**
	 * Adds a view. A view object contains the id of the view and the style rule
	 * Use enableMediaQuery(rule) to enable
	 * An array of view names are in self.addedViews array
	 */
	self.addView = function(viewId, cssRule, mediaRule, stateName) {
		var state = {name:viewId, rule:cssRule, id:viewId, mediaRule:mediaRule, stateName:stateName};
		self.addedViews.push(viewId);
		self.viewsDictionary[viewId] = state;
		self.mediaQueryDictionary[viewId] = cssRule;
	}

	self.hasView = function(name) {

		if (self.addedViews.indexOf(name)!=-1) {
			return true;
		}
		return false;
	}

	/**
	 * Go to view by id. Views are added in addView()
	 * @param {String} id id of view in current
	 * @param {Boolean} maintainPreviousState if true then do not hide other views
	 * @param {String} parent id of parent view
	 */
	self.goToView = function(id, maintainPreviousState, parent) {
		var state = self.viewsDictionary[id];

		if (state) {
			if (maintainPreviousState==false || maintainPreviousState==null) {
				self.hideViews();
			}
			self.enableMediaQuery(state.rule);
			self.updateViewLabel();
			self.updateURL();
		}
		else {
			var event = new Event(self.STATE_NOT_FOUND);
			self.stateName = id;
			window.dispatchEvent(event);
		}
	}

	/**
	 * Go to the view in the event targets CSS variable
	 */
	self.goToTargetView = function(event) {
		var button = event.currentTarget;
		var buttonComputedStyles = getComputedStyle(button);
		var actionTargetValue = buttonComputedStyles.getPropertyValue(self.prefix+"action-target").trim();
		var animation = buttonComputedStyles.getPropertyValue(self.prefix+"animation").trim();
		var targetType = buttonComputedStyles.getPropertyValue(self.prefix+"action-type").trim();
		var targetView = self.application ? null : self.getElement(actionTargetValue);
		var targetState = targetView ? self.getStateNameByViewId(targetView.id) : null;
		var actionTargetStyles = targetView ? targetView.style : null;
		var state = self.viewsDictionary[actionTargetValue];
		
		// navigate to page
		if (self.application==false || targetType=="page") {
			document.location.href = "./" + actionTargetValue;
			return;
		}

		// if view is found
		if (targetView) {

			if (self.currentOverlay) {
				self.removeOverlay(false);
			}

			if (self.showByMediaQuery) {
				var stateName = targetState;
				
				if (stateName==null || stateName=="") {
					var initialView = self.getInitialView();
					stateName = initialView ? self.getStateNameByViewId(initialView.id) : null;
				}
				self.showMediaQueryViewsByState(stateName, event);
				return;
			}

			// add animation set in event target style declaration
			if (animation && self.supportAnimations) {
				self.crossFade(self.currentView, targetView, false, animation);
			}
			else {
				self.setViewVariables(self.currentView);
				self.hideViews();
				self.enableMediaQuery(state.rule);
				self.scaleViewIfNeeded(targetView);
				self.centerView(targetView);
				self.updateViewLabel();
				self.updateURL();
			}
		}
		else {
			var stateEvent = new Event(self.STATE_NOT_FOUND);
			self.stateName = name;
			window.dispatchEvent(stateEvent);
		}

		event.stopImmediatePropagation();
	}

	/**
	 * Cross fade between views
	 **/
	self.crossFade = function(from, to, update, animation) {
		var targetIndex = to.parentNode
		var fromIndex = Array.prototype.slice.call(from.parentElement.children).indexOf(from);
		var toIndex = Array.prototype.slice.call(to.parentElement.children).indexOf(to);

		if (from.parentNode==to.parentNode) {
			var reverse = self.getReverseAnimation(animation);
			var duration = self.getAnimationDuration(animation, true);

			// if target view is above (higher index)
			// then fade in target view 
			// and after fade in then hide previous view instantly
			if (fromIndex<toIndex) {
				self.setElementAnimation(from, null);
				self.setElementAnimation(to, null);
				self.showViewByMediaQuery(to);
				self.fadeIn(to, update, animation);

				setTimeout(function() {
					self.setElementAnimation(to, null);
					self.setElementAnimation(from, null);
					self.hideView(from);
					self.updateURL();
					self.setViewVariables(to);
					self.updateViewLabel();
				}, duration)
			}
			// if target view is on bottom
			// then show target view instantly 
			// and fade out current view
			else if (fromIndex>toIndex) {
				self.setElementAnimation(to, null);
				self.setElementAnimation(from, null);
				self.showViewByMediaQuery(to);
				self.fadeOut(from, update, reverse);

				setTimeout(function() {
					self.setElementAnimation(to, null);
					self.setElementAnimation(from, null);
					self.hideView(from);
					self.updateURL();
					self.setViewVariables(to);
				}, duration)
			}
		}
	}

	self.fadeIn = function(element, update, animation) {
		self.showViewByMediaQuery(element);

		if (update) {
			self.updateURL(element);

			element.addEventListener("animationend", function(event) {
				element.style.animation = null;
				self.setViewVariables(element);
				self.updateViewLabel();
				element.removeEventListener("animationend", arguments.callee);
			});
		}

		self.setElementAnimation(element, null);
		
		element.style.animation = animation;
	}

	self.fadeOutCurrentView = function(animation, update) {
		if (self.currentView) {
			self.fadeOut(self.currentView, update, animation);
		}
		if (self.currentOverlay) {
			self.fadeOut(self.currentOverlay, update, animation);
		}
	}

	self.fadeOut = function(element, update, animation) {
		if (update) {
			element.addEventListener("animationend", function(event) {
				element.style.animation = null;
				self.hideView(element);
				element.removeEventListener("animationend", arguments.callee);
			});
		}

		element.style.animationPlayState = "paused";
		element.style.animation = animation;
		element.style.animationPlayState = "running";
	}

	self.getReverseAnimation = function(animation) {
		if (animation && animation.indexOf("reverse")==-1) {
			animation += " reverse";
		}

		return animation;
	}

	/**
	 * Get duration in animation string
	 * @param {String} animation animation value
	 * @param {Boolean} inMilliseconds length in milliseconds if true
	 */
	self.getAnimationDuration = function(animation, inMilliseconds) {
		var duration = 0;
		var expression = /.+(\d\.\d)s.+/;

		if (animation && animation.match(expression)) {
			duration = parseFloat(animation.replace(expression, "$" + "1"));
			if (duration && inMilliseconds) duration = duration * 1000;
		}

		return duration;
	}

	self.setElementAnimation = function(element, animation, priority) {
		element.style.setProperty("animation", animation, "important");
	}

	self.getElement = function(id) {
		var elementId = id ? id.trim() : id;
		var element = elementId ? document.getElementById(elementId) : null;

		return element;
	}

	self.resizeHandler = function(event) {
		
		if (self.showByMediaQuery) {
			if (self.enableDeepLinking) {
				var stateName = self.getHashFragment();

				if (stateName==null || stateName=="") {
					var initialView = self.getInitialView();
					stateName = initialView ? self.getStateNameByViewId(initialView.id) : null;
				}
				self.showMediaQueryViewsByState(stateName, event);
			}
		}
		else {
			var visibleViews = self.getVisibleViews();

			for (let index = 0; index < visibleViews.length; index++) {	
				var view = visibleViews[index];
				self.scaleViewIfNeeded(view);
			}
		}

		window.dispatchEvent(new Event(self.APPLICATION_RESIZE));
	}

	self.scaleViewIfNeeded = function(view) {

		if (self.scaleViewsOnResize) {
			if (view==null) {
				view = self.getVisibleView();
			}

			var isViewScaled = view.getAttributeNS(null, self.SIZE_STATE_NAME)=="false" ? false : true;

			if (isViewScaled) {
				self.scaleViewToFit(view, true);
			}
			else {
				self.scaleViewToActualSize(view);
			}
		}
		else if (view) {
			self.centerView(view);
		}
	}

	self.centerView = function(view) {

		if (self.scaleViewsToFit) {
			self.scaleViewToFit(view, true);
		}
		else {
			self.scaleViewToActualSize(view);  // for centering support for now
		}
	}

	self.preventDoubleClick = function(event) {
		event.stopImmediatePropagation();
	}

	self.getHashFragment = function() {
		var value = window.location.hash ? window.location.hash.replace("#", "") : "";
		return value;
	}

	self.showBlockElement = function(view) {
		view.style.display = "block";
	}

	self.hideElement = function(view) {
		view.style.display = "none";
	}

	self.showStateFunction = null;

	self.showMediaQueryViewsByState = function(state, event) {
		// browser will hide and show by media query (small, medium, large)
		// but if multiple views exists at same size user may want specific view
		// if showStateFunction is defined that is called with state fragment and user can show or hide each media matching view by returning true or false
		// if showStateFunction is not defined and state is defined and view has a defined state that matches then show that and hide other matching views
		// if no state is defined show view 
		// an viewChanging event is dispatched before views are shown or hidden that can be prevented 

		// get all matched queries
		// if state name is specified then show that view and hide other views
		// if no state name is defined then show
		var matchedViews = self.getMatchingViews();
		var matchMediaQuery = true;
		var foundViews = self.getViewsByStateName(state, matchMediaQuery);
		var showViews = [];
		var hideViews = [];

		// loop views that match media query 
		for (let index = 0; index < matchedViews.length; index++) {
			var view = matchedViews[index];
			
			// let user determine visible view
			if (self.showStateFunction!=null) {
				if (self.showStateFunction(view, state)) {
					showViews.push(view);
				}
				else {
					hideViews.push(view);
				}
			}
			// state was defined so check if view matches state
			else if (foundViews.length) {

				if (foundViews.indexOf(view)!=-1) {
					showViews.push(view);
				}
				else {
					hideViews.push(view);
				}
			}
			// if no state names are defined show view (define unused state name to exclude)
			else if (state==null || state=="") {
				showViews.push(view);
			}
		}

		if (showViews.length) {
			var viewChangingEvent = new Event(self.VIEW_CHANGING);
			viewChangingEvent.showViews = showViews;
			viewChangingEvent.hideViews = hideViews;
			window.dispatchEvent(viewChangingEvent);

			if (viewChangingEvent.defaultPrevented==false) {
				for (var index = 0; index < hideViews.length; index++) {
					var view = hideViews[index];

					if (self.isOverlay(view)) {
						self.removeOverlay(view);
					}
					else {
						self.hideElement(view);
					}
				}

				for (var index = 0; index < showViews.length; index++) {
					var view = showViews[index];

					if (index==showViews.length-1) {
						self.clearDisplay(view);
						self.setViewOptions(view);
						self.setViewVariables(view);
						self.centerView(view);
						self.updateURLState(view, state);
					}
				}
			}

			var viewChangeEvent = new Event(self.VIEW_CHANGE);
			viewChangeEvent.showViews = showViews;
			viewChangeEvent.hideViews = hideViews;
			window.dispatchEvent(viewChangeEvent);
		}
		
	}

	self.clearDisplay = function(view) {
		view.style.setProperty("display", null);
	}

	self.hashChangeHandler = function(event) {
		var fragment = self.getHashFragment();
		var view = self.getViewById(fragment);

		if (self.showByMediaQuery) {
			var stateName = fragment;

			if (stateName==null || stateName=="") {
				var initialView = self.getInitialView();
				stateName = initialView ? self.getStateNameByViewId(initialView.id) : null;
			}
			self.showMediaQueryViewsByState(stateName);
		}
		else {
			if (view) {
				self.hideViews();
				self.showView(view);
				self.setViewVariables(view);
				self.updateViewLabel();
				
				window.dispatchEvent(new Event(self.VIEW_CHANGE));
			}
			else {
				window.dispatchEvent(new Event(self.VIEW_NOT_FOUND));
			}
		}
	}

	self.popStateHandler = function(event) {
		var state = event.state;
		var fragment = state ? state.name : window.location.hash;
		var view = self.getViewById(fragment);

		if (view) {
			self.hideViews();
			self.showView(view);
			self.updateViewLabel();
		}
		else {
			window.dispatchEvent(new Event(self.VIEW_NOT_FOUND));
		}
	}

	self.doubleClickHandler = function(event) {
		var view = self.getVisibleView();
		var scaleValue = view ? self.getViewScaleValue(view) : 1;
		var scaleNeededToFit = view ? self.getViewFitToViewportScale(view) : 1;
		var scaleNeededToFitWidth = view ? self.getViewFitToViewportWidthScale(view) : 1;
		var scaleNeededToFitHeight = view ? self.getViewFitToViewportHeightScale(view) : 1;
		var scaleToFitType = self.scaleToFitType;

		// Three scenarios
		// - scale to fit on double click
		// - set scale to actual size on double click
		// - switch between scale to fit and actual page size

		if (scaleToFitType=="width") {
			scaleNeededToFit = scaleNeededToFitWidth;
		}
		else if (scaleToFitType=="height") {
			scaleNeededToFit = scaleNeededToFitHeight;
		}

		// if scale and actual size enabled then switch between
		if (self.scaleToFitOnDoubleClick && self.actualSizeOnDoubleClick) {
			var isViewScaled = view.getAttributeNS(null, self.SIZE_STATE_NAME);
			var isScaled = false;
			
			// if scale is not 1 then view needs scaling
			if (scaleNeededToFit!=1) {

				// if current scale is at 1 it is at actual size
				// scale it to fit
				if (scaleValue==1) {
					self.scaleViewToFit(view);
					isScaled = true;
				}
				else {
					// scale is not at 1 so switch to actual size
					self.scaleViewToActualSize(view);
					isScaled = false;
				}
			}
			else {
				// view is smaller than viewport 
				// so scale to fit() is scale actual size
				// actual size and scaled size are the same
				// but call scale to fit to retain centering
				self.scaleViewToFit(view);
				isScaled = false;
			}
			
			view.setAttributeNS(null, self.SIZE_STATE_NAME, isScaled+"");
			isViewScaled = view.getAttributeNS(null, self.SIZE_STATE_NAME);
		}
		else if (self.scaleToFitOnDoubleClick) {
			self.scaleViewToFit(view);
		}
		else if (self.actualSizeOnDoubleClick) {
			self.scaleViewToActualSize(view);
		}

	}

	self.scaleViewToFit = function(view) {
		return self.setViewScaleValue(view, true);
	}

	self.scaleViewToActualSize = function(view) {
		self.setViewScaleValue(view, false, 1);
	}

	self.onloadHandler = function(event) {
		self.initialize();
	}

	self.setElementHTML = function(id, value) {
		var element = self.getElement(id);
		element.innerHTML = value;
	}

	self.getStackArray = function(error) {
		var value = "";
		
		if (error==null) {
		  try {
			 error = new Error("Stack");
		  }
		  catch (e) {
			 
		  }
		}
		
		if ("stack" in error) {
		  value = error.stack;
		  var methods = value.split(/\n/g);
	 
		  var newArray = methods ? methods.map(function (value, index, array) {
			 value = value.replace(/\@.*/,"");
			 return value;
		  }) : null;
	 
		  if (newArray && newArray[0].includes("getStackTrace")) {
			 newArray.shift();
		  }
		  if (newArray && newArray[0].includes("getStackArray")) {
			 newArray.shift();
		  }
		  if (newArray && newArray[0]=="") {
			 newArray.shift();
		  }
	 
			return newArray;
		}
		
		return null;
	}

	self.log = function(value) {
		console.log.apply(this, [value]);
	}
	
	// initialize on load
	// sometimes the body size is 0 so we call this now and again later
	window.addEventListener("load", self.onloadHandler);
	window.document.addEventListener("DOMContentLoaded", self.onloadHandler);
}

window.application = new Application();
</script>
</head>
<body>
<div id="Web_1920__1">
	<img id="siteicon" src="data:image/png;base64,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">
	<div id="HAPPY">
		<span>HAPPY</span>
	</div>
	<div id="Diagnostic_Clinic">
		<span>Diagnostic Clinic</span>
	</div>
	<div id="X-ray_-_Ultrasound_-_Laborator">
		<span>X-ray - Ultrasound - Laboratory - ECG: Mon to Sat : 8am to 4pm</span>
	</div>
	<div id="ID2nd_Floor_Friendship_Superma">
		<span>2</span><span style="vertical-align:super;">nd</span><span> Floor, Friendship Supermarket Building II, Brgy. Tay-ac, Rosario, La Union<br/>Contact numbers: 0927-502-7614: 0939-773-9242 (DURING CLINIC HOURS ONLY)</span>
	</div>
	<svg class="Line_1" viewBox="0 0 2 144">
		<path id="Line_1" d="M 0 0 L 0 144">
		</path>
	</svg>
	<svg class="Rectangle_1">
		<rect id="Rectangle_1" rx="0" ry="0" x="0" y="0" width="472" height="57">
		</rect>
	</svg>
	<div id="RADIOLOGY_REPORT">
		<span>RADIOLOGY REPORT</span>
	</div>
	<div id="PATIENT">
		<span>PATIENT</span>
	</div>
</div>
</body>
</html>