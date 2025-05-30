<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmation extends Notification
{
    use Queueable;

    public $order;
    public $total;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, $total)
    {
        $this->order = $order;
        $this->total = $total;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmation de commande')
            ->greeting('Bonjour ' . $notifiable->firstname . ' 👋')
            ->line('Merci d\'avoir passé une commande sur notre site !')
            ->line('Voici les détails de votre commande n°' . $this->order->id)
            ->line('Total : ' . $this->total . ' €')
            ->line('Nous vous remercions pour votre achat et espérons vous revoir bientôt !')
            ->salutation('À bientôt, l’équipe KLIN KLIN 👕');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
