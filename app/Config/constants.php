<?php
/**
 * Burrow
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    Burrow
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class ConstCommsisionType
{
    const Amount = 'amount';
    const Percentage = 'percentage';
}
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
}
class ConstStreetView
{
    const HideStreetView = 1;
    const CloseToMyAddress = 2;
    const NearBy = 3;
}
class ConstStreetAction
{
    const Hidestreetview = 1;
    const Closesttoaddress = 2;
    const Nearby = 3;
}
class ConstMeasureAction
{
    const Squarefeet = 1;
    const Squaremeasures = 2;
}
class ConstAttachment
{
    const UserAvatar = 1;
    const Property = 3;
}
class ConstFriendRequestStatus
{
    const Pending = 1;
    const Approved = 2;
    const Reject = 3;
}
class ConstMessageFolder
{
    const Inbox = 1;
    const SentMail = 2;
    const Drafts = 3;
    const Spam = 4;
    const Trash = 5;
}
class ConstNegotiationStatus
{
    const NegotiationRequested = 1;
    const NegotiationAccepted = 2;
    const NegotiationRejected = 3;
}
// Setting for privacy settings
class ConstPrivacySetting
{
    const EveryOne = 1;
    const Users = 2;
    const Friends = 3;
    const Nobody = 4;
}
class ConstProjectStatus
{
    const Confirmed = 18;
    const Rejected = 6;
    const Available = 16;
    const NotAvailable = 17;
    const Pending = 2;
    const Waiting = 1;
    const Completed = 4;
    const Canceled = 5;
}
class ConstMoreAction
{
    const Inactive = 1;
    const Active = 2;
    const Delete = 3;
    const OpenID = 4;
    const Export = 5;
    const Normal = 38;
    const IsReplied = 23;
    const Unsatisfy = 11;
    const Satisfy = 10;
    const UserFlagged = 37;
    const NotifiedInactiveUsers = 30;
    const Approved = 6;
    const Disapproved = 7;
    const Featured = 8;
    const Notfeatured = 9;
    const Unflagged = 14;
    const Facebook = 23;
    const Twitter = 22;
    const Gmail = 39;
    const Yahoo = 40;
	const LinkedIn = 41;
	const GooglePlus = 42;
    const Flagged = 13;
    const Unsuspend = 15;
    const Suspend = 10;
    const Negotiable = 15;
    const WaitingforAcceptance = 1;
    const InProgress = 2;
    const Completed = 4;
    const Canceled = 5;
    const Rejected = 6;
    const PaymentCleared = 7;
    const HomePage = 41;
    const Verified = 42;
    const WaitingForVerification = 43;
	const Collection = 44;
	const Imported = 45;
	const TestMode = 46;
	const MassPay = 47;
	const PropertyListing = 48;
	const PropertyVerification = 49;
	const AddWallet = 50;
	const PropertyBooking = 51;
	const SignupFee = 52;
	const Prelaunch = 53;
	const PrivateBeta = 54;
	const PrelaunchSubscribed = 55;
	const PrivateBetaSubscribed = 56;	
	const Subscribed = 57;
	const Unsubscribed = 58;
}
// Banned ips types
class ConstBannedTypes
{
    const SingleIPOrHostName = 1;
    const IPRange = 2;
    const RefererBlock = 3;
}
// Banned ips durations
class ConstBannedDurations
{
    const Permanent = 1;
    const Days = 2;
    const Weeks = 3;
}
//payment related class constant
class ConstPaymentGateways
{
    const SudoPay = 1;
    const Wallet = 2;
	// mass payment manual
	const ManualPay = 5;
}
class ConstPaymentGatewaysName
{
    const SudoPay = 'ZazPay';
    const Wallet = 'Wallet';
}
class ConstUserIds
{
    const Admin = 1;
}
class ConstDisputeStatus
{
    const Open = 1;
    const UnderDiscussion = 2;
    const WaitingForAdministratorDecision = 3;
    const Closed = 4;
}
class ConstPropertyUserType
{
    const Traveler = 1;
    const Host = 2;
}
class ConstVerification
{
    const VerificationRejected = 0;
    const Verified = 1;
    const WaitingForVerification = 2;
}
class ConstPaymentGatewayFilterOptions
{
    const Active = 1;
    const Inactive = 2;
    const TestMode = 3;
    const LiveMode = 4;
}
class ConstPaymentGatewayMoreActions
{
    const Activate = 1;
    const Deactivate = 2;
    const MakeTestMode = 3;
    const MakeLiveMode = 4;
    const Delete = 5;
}
class ConstTransactionTypes
{
	const SignupFee = 1;
    const AddedToWallet = 2;
	const PropertyListingFee = 3;
    const PropertyVerifyFee = 4;
    const BookProperty = 5;
    const RefundForExpiredBooking = 6;
    const RefundForRejectedBooking = 7;
    const RefundForCanceledBooking = 8;
    const RefundForBookingCanceledByAdmin = 9;
    const HostAmountCleared = 10;
	const SecurityDepositSentToHost = 11;
	const SecurityDepositRefundedToTraveler = 12;
	const RefundForPropertySpecificationDispute = 13;
	const SecurityDepositAutoRefunded = 14;
    const CashWithdrawalRequest = 15;
    const CashWithdrawalRequestApproved = 16;
    const CashWithdrawalRequestRejected = 17;
    const CashWithdrawalRequestPaid = 18;
    const CashWithdrawalRequestFailed = 19;
    const AffliateCashWithdrawalRequest = 20;
    const AffliateCashWithdrawalRequestRejected = 21;
    const AffliateCashWithdrawalRequestPaid = 22;
    const AffliateCashWithdrawalRequestFailed = 23;
    const AffliateCashWithdrawalRequestApproved = 24;
	const AdminAddFundToWallet = 25;
    const AdminDeductFundFromWallet = 26;
}
class ConstPropertyUserStatus
{
    const WaitingforAcceptance = 1;
    const Confirmed = 2;
    const Rejected = 3;
    const Canceled = 4;
    const Arrived = 5;
    const WaitingforReview = 6;
    const PaymentCleared = 7;
    const Completed = 8;
    const Expired = 9;
    const CanceledByAdmin = 10;
    const PaymentPending = 12;
    const FromTravelerConversation = 36;
    const PrivateConversation = 37;
    const NegotiateConversation = 38;
    const AdminDisputeConversation = 39;
    const DisputeAdminAction = 40;
    const WorkReviewed = 41;
    const WorkDelivered = 42;
    const DisputeClosedTemp = 43; // temp; for not to show the second dispute mail
    const DisputeClosed = 44;
    const DisputeConversation = 45;
    const DisputeOpened = 46;
    const SenderNotification = 50;
	const RequestNegotiation = 51;
	const SecurityDepositRefund = 52;
	const HostReviewed = 13;
}
class ConstCancellationPolicy
{
    const Flexible = 1;
    const Moderate = 2;
    const Strict = 3;
}
class ConstCancellationPolicyRefundDay
// Values in days //

{
    const Flexible = 1;
    const Moderate = 5;
    const Strict = 7;
}
class ConstPropertyStatus
{
    const NotAvailable = 0;
    const Available = 1;
}
class ConstPropertyUser
{
    const Paid = 1;
    const notpaid = 0;
}
class ConstPaymentGatewayFlow
{
    const TravelerSiteHost = 'Traveler -> Site -> Host';
    const TravelerHostSite = 'Traveler -> Host -> Site';
}
class ConstPaymentGatewayFee
{
    const Host = 'Host';
    const Site = 'Site';
    const SiteAndHost = 'Site and Host';
}
class ConstViewType
{
    const NormalView = 1;
    const EmbedView = 2;
}
class ConstSecurityDepositStatus
{
    const Blocked = 0;
    const SentToHost = 1;
    const RefundedToTraveler = 2;
}
class ConstModule
{
    const Affiliate = 14;
    const Friends = 12;
}
class ConstModuleEnableFields
{
    const Affiliate = 160;
    const Friends = 253;
}
class ConstPaymentType
{
    const TravelerFeeToSite = 1;
	const BookingAmount = 2;
	const CancelBookingAmount = 3;
	const SecurityDepositToHost = 4;
	const DisputeBookingAmount = 5;
	const AddAmountToWallet = 6;
	const PropertyListingFee = 7;
	const PropertyVerifyFee = 8;
	const SignupFee = 9;
}
class ConstSiteState
{
    const Prelaunch = 1;
	const PrivateBeta = 2;
	const Launched = 3;
}
class ConstUserAvatarSource
{
    const Attachment = 1;
	const Facebook = 2;
	const Twitter = 3;
	const Google = 4;
	const Linkedin = 5;
	const GooglePlus = 6;
}
// @todo "Auto review"
// @todo "Ask Question"
?>